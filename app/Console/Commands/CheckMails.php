<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpDocumentor\Reflection\Types\Null_;
use Webklex\IMAP\Facades\Client;
use App\Models\Transaction;
use App\Models\Word;
use Carbon\Carbon;

class CheckMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check configured email client for new emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get email client and connection
        $client = Client::account('snadnee');
        $client->connect();
        // load all unread messages from inbox
        $inbox = $client->getFolder('INBOX');
        $messages = $inbox->query()->unseen()->get();
        // for each message get needed email body components and insert into DB
        foreach ($messages as $message) {
            $params = array();
            $note_words = array();
            $this->getPaymentParams($message->getTextBody(), $params);
            $this->getNoteWords($message->getTextBody(), $note_words);
            //insert message to database if all needed params were found
            if(count($params) == 8) {
                $new_transaction = Transaction::create($params);
                if(count($note_words) == 1){
                    $new_words = explode(" ", $note_words['note']);
                    $new_words = array_map('strtoupper', $new_words);
                    $db_word = Word::where('name', '=', $new_words[0])->first();
                    if($db_word == null){
                        $db_word = Word::create(['name' => $new_words[0]]);
                    }
                    $new_transaction->word()->associate($db_word);
                    $new_transaction->save();
                }
            }
        }
    }

    /**
     * Get payment params from email body
     */
    private function getPaymentParams($text, &$params)
    {
        $this->getSenderAccount($text, $params);
        $this->getReceiverAccount($text, $params);
        $this->getPrice($text, $params);
        $this->getDate($text,$params);
        $this->getKS($text,$params);
        $this->getVS($text,$params);
        $this->getSS($text,$params);
    }

    private function getSenderAccount($str, &$params)
    {
        preg_match('/(From):([0-9]*\/[0-9]*)/', $str, $output_array);
        if(count($output_array) == 3) {
            $params['sender_account'] = $output_array[2];
        }
    }

    private function getReceiverAccount($str, &$params)
    {
        preg_match('/(To):([0-9]*\/[0-9]*)/', $str, $output_array);
        if(count($output_array) == 3) {
            $params['receiver_account'] = $output_array[2];
        }
    }

    private function getPrice($str, &$params)
    {
        preg_match('/(Price):([0-9]*,[0-9]*)(\s[A-Z]{3,})/', $str, $output_array);
        if(count($output_array) == 4) {
            $params['price'] = str_replace(",", ".", $output_array[2]);
            $params["currency"] = $output_array[3];
        }
    }

    private function getDate($str, &$params)
    {
        preg_match('/(Date):(\d{2}.\d{2}.\d{4}\s\d{2}:\d{2})/', $str, $output_array);
        if(count($output_array) == 3) {
            $params['datetime'] = Carbon::createFromFormat('d.m.Y H:i', $output_array[2]);
        }
    }

    private function getKS($str, &$params)
    {
        preg_match('/(KS):(\d{4,8})/', $str, $output_array);
        if(count($output_array) == 3) {
            $params['KS'] = $output_array[2];
        }
    }

    private function getVS($str, &$params)
    {
        preg_match('/(VS):(\d{6,10})/', $str, $output_array);
        if(count($output_array) == 3) {
            $params['VS'] = $output_array[2];
        }
    }

    private function getSS($str, &$params)
    {
        preg_match('/(SS):(\d{4,8})/', $str, $output_array);
        if(count($output_array) == 3) {
            $params['SS'] = $output_array[2];
        }
    }

    /**
     * Get note words from email body
     * For now only the first word is used.
     */
    private function getNoteWords($str, &$note_words)
    {
        preg_match('/(Note):(.*)/', $str, $output_array);
        if(count($output_array) == 3) {
            $arr = explode(";", $output_array[2]);
            $note_words['note'] = $arr[0];
        }
    }



}

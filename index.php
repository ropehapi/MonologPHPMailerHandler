<?php

use App\PHPMailerHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\BrowserConsoleHandler;

require __DIR__ . "/vendor/autoload.php";

//Nome desse Agente Logger
$logger = new Logger("web");

//Defino o handler de Log no browser
$logger->pushHandler(new BrowserConsoleHandler(Logger::DEBUG));

//Defino o handler de Log para arquivos
$logger->pushHandler(new StreamHandler(__DIR__ . "/log.txt", Logger::WARNING));

//Defino o handler de Log para email
$logger->pushHandler(new PHPMailerHandler(
    "mail_from@example.com.br",
    "mail_to@example.com",
    "Message",
    Logger::CRITICAL));

//Defino dados adicionais que eu quero que saiam no LOG
$logger->pushProcessor(function ($record) {
    $record["extra"]["HTTP_HOST"] = $_SERVER["HTTP_HOST"];
    $record["extra"]["REQUEST_URI"] = $_SERVER["REQUEST_URI"];
    $record["extra"]["REQUEST_METHOD"] = $_SERVER["REQUEST_METHOD"];
    $record["extra"]["HTTP_USER_AGENT"] = $_SERVER["HTTP_USER_AGENT"];
    return $record;
});

//Daqui pra baixo tudo vai pro console
$logger->debug("Erro a nível de debug", ["logger" => true]);
$logger->info("Erro a nível de info", ["logger" => true]);
$logger->notice("Erro a nível de notice", ["logger" => true]);

//Daqui pra baixo tudo vai pro arquivo
$logger->warning("Erro a nível de warning", ["logger" => true]);
$logger->error("Erro a nível de error", ["logger" => true]);

//Daqui pra baixo tudo vai pro Email
$logger->critical("Erro a nível de critical", ["logger" => true]);
$logger->alert("Erro a nível de alert", ["logger" => true]);
$logger->emergency("Erro a nível de emergency", ["logger" => true]);
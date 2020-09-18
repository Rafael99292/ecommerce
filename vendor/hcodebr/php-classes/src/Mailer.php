<?php 

namespace Hcode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Rain\Tpl;

class Mailer{

	const USERNAME = "endereco de email";
	const PASSWORD = "senha do email";
	const NAME_FROM = "Hcode Store";

	private $mail;

	public function __construct($toAddres, $toName, $subject, $tplName, $data = array()){

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/"
		);

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

		$this->mail = new PHPMailer(true);
		$this->mail->CharSet = 'UTF-8';

		// Diga ao PHPMailer para usar SMTP

		$this->mail-> isSMTP ();

		// Ativar depuração SMTP

		// SMTP :: DEBUG_OFF = desativado (para uso em produção)

		// SMTP :: DEBUG_CLIENT = mensagens do cliente

		// SMTP :: DEBUG_SERVER = mensagens do cliente e do servidor

		$this->mail->SMTPDebug = SMTP :: DEBUG_OFF;

		// Define o nome do host do servidor de email

		$this->mail->Host = 'smtp.gmail.com';

		// $ mail-> Host = gethostbyname ('smtp.gmail.com');

		// se sua rede não suportar SMTP sobre IPv6

		// Defina o número da porta SMTP - 587 para TLS autenticado, também conhecido como envio SMTP RFC4409

		$this->mail->Port = 587;

		// Defina o mecanismo de criptografia a usar - STARTTLS ou SMTPS

		$this->mail->SMTPSecure = PHPMailer :: ENCRYPTION_STARTTLS;

		// Se deve usar autenticação SMTP

		$this->mail->SMTPAuth = true;

		// Nome de usuário a ser usado para autenticação SMTP - use o endereço de e-mail completo para o gmail
		$this->mail->Username = Mailer::USERNAME;

		// Senha a ser usada para autenticação SMTP
		$this->mail->Password = Mailer::PASSWORD;

		// Define de quem a mensagem deve ser enviada
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

		// Defina um endereço de resposta alternativo

		//$ mail-> addReplyTo ('replyto@example.com ',' Primeiro Último ');

		// Defina para quem a mensagem deve ser enviada
		$this->mail-> addAddress ($toAddres, $toName);

		// Define a linha de assunto
		$this->mail->Subject = $subject;

		// Leia um corpo da mensagem HTML de um arquivo externo, converta imagens referenciadas em incorporadas,

		// converte HTML em um corpo alternativo básico de texto sem formatação

		$this->mail->msgHTML($html);

		// Substitua o corpo do texto sem formatação por um criado manualmente

		$this->mail->AltBody = 'Este é um corpo de mensagem em texto sem formatação';

		// Anexar um arquivo de imagem

		// $ mail-> addAttachment ('images / phpmailer_mini.png');

		// envia a mensagem, verifica se há erros

	}

	public function send(){

		return $this->mail->send();

	}

}

 ?>
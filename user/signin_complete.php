<?php
require_once(__DIR__ . '/../dao/UserDao.php');
require_once(__DIR__ . '/../UseCase/UseCaseInput/SignInInput.php');
require_once(__DIR__ . '/../UseCase/UseCaseInteractor/SignInInteractor.php');
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../ValueObject/Email.php');
require_once(__DIR__ . '/../ValueObject/InputPassword.php');
require_once(__DIR__ . '/../UseCase/UseCaseInput/SignInInput.php');

session_start();
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if (empty($email) || empty($password)) {
    $_SESSION['errors'][] = "パスワードとメールアドレスを入力してください";
    redirect("./user/signin.php");
}

$userEmail = new Email($email);
$inputPassword = new InputPassword($password);
$useCaseInput = new SignInInput($userEmail, $inputPassword);
$useCase = new SignInInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();

if ($useCaseOutput->isSuccess()) {
    redirect("../index.php");
} else {
    $_SESSION['errors'][] = $useCaseOutput->message();
    redirect("./user/signin.php");
}
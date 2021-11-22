<?php
require_once(__DIR__ . '/../dao/UserDao.php');
require_once(__DIR__ . '../UseCase/UseCaseInput/SignInInput.php');
require_once(__DIR__ . '../UseCase/UseCaseInteractor/SignInInteractor.php');
require_once(__DIR__ . '/../utils/redirect.php');

session_start();
$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

if (empty($mail) || empty($password)) {
    $_SESSION['errors'][] = "パスワードとメールアドレスを入力してください";
    redirect("./user/signin.php");
}

$userEmail = new UserEmail($mail);
$userPassword = new UserPassword($password);
$useCaseInput = new SignInInput($userEmail, $userPassword);
$useCase = new SignInInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();

if ($useCaseOutput->isSuccess()) {
    redirect("../index.php");
} else {
    $_SESSION['errors'][] = $useCaseOutput->message();
    redirect("./user/signin.php");
}
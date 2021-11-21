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

$useEmail = new UserEmail($mail);
$useCaseInput = new SignInInput($mail, $password);
$useCase = new SignInInteractor($useCaseInput);
$useCaseOutput = $useCase->handler();

if ($useCaseOutput->isSuccess()) {
    $_SESSION['formInputs']['userId'] = $useCaseOutput->signInResult()['id'];
    $_SESSION['formInputs']['userName'] = $useCaseOutput->signInResult()['user_name'];;
    redirect("../index.php");
} else {
    $_SESSION['errors'][] = $useCaseOutput->signInResult();
    redirect("./user/signin.php");
}
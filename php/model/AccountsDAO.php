<?php

interface AccountsDAO
{
    public function createAccount($email, $password) : int;

    public function readAccount($id) : Account;

    public function readAccountByEmail($email) : Account;

    public function updateAccount($id, $email, $password_old, $password_new) : void;

    public function deleteAccount($id) : void;

    public function readAllAccounts() : array;

    public function activateAccount(int $id): void;
}
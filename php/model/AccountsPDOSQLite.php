<?php

require_once "Account.php";
require_once "AccountsDAO.php";
require_once "AbstractPDOSQLite.php";
require_once "InternalErrorException.php";
require_once "MissingEntryException.php";

class AccountsPDOSQLite extends AbstractPDOSQLite implements AccountsDAO
{
    private static AccountsDAO|null $instance = null;

    public static function getInstance(): AccountsDAO
    {
        if (self::$instance == null) {
            self::$instance = new AccountsPDOSQLite();
        }

        return self::$instance;
    }

    /**
     * @throws EmailAlreadyExistsException
     * @throws InternalErrorException
     */
    public function createAccount($email, $password): int
    {
        try {
            $db = $this->getConnection();
            $db->beginTransaction();

            $sql = "SELECT * FROM account WHERE email = :email;";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([":email" => $email]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $result = $command->fetch();
            if (!empty($result)) {
                $db->rollBack();
                throw new EmailAlreadyExistsException();
            }

            $sql = "
                INSERT INTO
                    account (email, password)
                VALUES
                    (:email, :password)
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([
                ":email" => $email,
                ":password" => password_hash($password, PASSWORD_DEFAULT),
            ]);

            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $db->commit();

            return intval($db->lastInsertId());
        } catch (PDOException $exception) {
            $db->rollBack();
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }


    /**
     * @throws InternalErrorException
     * @throws MissingEntryException
     */
    public function readAccount($id): Account
    {
        try {
            $db = $this->getConnection();
            $sql = "
                SELECT * FROM account WHERE id = :id;
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id]);
            if (!$success) {
                throw new InternalErrorException();
            }

            $result = $command->fetchAll();
            if (empty($result)) {
                throw new MissingEntryException();
            }

            $result = $result[0];
            $account = new Account(intval($result["id"]), $result["email"], $result["password"]);
            $account->update(
                $result["email"],
                $result["password"],
                boolval($result["active"])
            );
            return $account;
        } catch (PDOException $exception) {
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    /**
     * @throws InternalErrorException
     * @throws MissingEntryException
     */
    public function readAccountByEmail($email): Account
    {
        try {
            $db = $this->getConnection();
            $sql = "
                SELECT * FROM account WHERE email = :email;
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }

            $success = $command->execute([":email" => $email]);
            if (!$success) {
                throw new InternalErrorException();
            }

            $result = $command->fetchAll();
            if (empty($result)) {
                throw new MissingEntryException();
            }

            $result = $result[0];
            $account = new Account(intval($result["id"]), $result["email"], $result["password"]);
            $account->update(
                $result["email"],
                $result["password"],
                boolval($result["active"])
            );
            return $account;
        } catch (PDOException $exception) {
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    /**
     * @throws InternalErrorException
     * @throws MissingEntryException|
     * @throws WrongPasswordException
     */
    public function updateAccount($id, $email, $password_old, $password_new): void
    {
        try {
            $db = $this->getConnection();
            $db->beginTransaction();

            $sql = "SELECT * FROM account WHERE id = :id;";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $result = $command->fetch();
            if (empty($result)) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $account = new Account(intval($result["id"]), $result["email"], $result["password"]);
            if ($account->checkPassword($password_old)) {
                $account->update($email, $password_new);
            } else {
                $db->rollBack();
                throw new WrongPasswordException();
            }

            $sql = "
                UPDATE
                    account 
                SET 
                    email = :email, 
                    password = :password
                WHERE
                    id = :id
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([
                ":email" => $account->getEmail(),
                ":password" => password_hash($account->getPassword(), PASSWORD_DEFAULT),
                ":id" => $account->getId(),
            ]);

            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            if ($command->rowCount() === 0) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $db->commit();
        } catch (PDOException $exception) {
            $db->rollBack();
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    /**
     * @throws InternalErrorException
     * @throws MissingEntryException
     */
    public function deleteAccount($id): void
    {
        try {
            $db = $this->getConnection();
            $db->beginTransaction();

            $sql = "SELECT * FROM account WHERE id = :id";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $result = $command->fetch();
            if (empty($result)) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $sql = "DELETE FROM account WHERE id = :id";
            $command = $db->prepare($sql);

            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            if (!$command->execute([":id" => $id])) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            if ($command->rowCount() === 0) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $db->commit();
        } catch (PDOException $exception) {
            $db->rollBack();
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    /**
     * @throws InternalErrorException
     */
    public function readAllAccounts(): array
    {
        try {
            $db = $this->getConnection();
            $sql = "
                SELECT 
                    id,
                    email,
                    password
                FROM
                    account
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }

            if (!$command->execute()) {
                throw new InternalErrorException();
            }

            $accounts = [];

            while ($row = $command->fetch(PDO::FETCH_ASSOC)) {
                if (!isset($accounts[$row['id']])) {
                    $accounts[$row['id']] = new Account(
                        intval($row['id']),
                        $row['email'],
                        $row['password']
                    );
                }
            }

            return $accounts;
        } catch (PDOException $exception) {
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    public function activateAccount(int $id): void
    {
        try {
            $db = $this->getConnection();
            $db->beginTransaction();

            $sql = "SELECT * FROM account WHERE id = :id;";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $result = $command->fetch();
            if (empty($result)) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $sql = "UPDATE account SET active = 1 WHERE id = :id";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            if ($command->rowCount() === 0) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $db->commit();
        } catch (PDOException $exception) {
            $db->rollBack();
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }
}
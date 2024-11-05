<?php

require_once "Beitrag.php";
require_once "SammlungDAO.php";
require_once "Account.php";
require_once "AbstractPDOSQLite.php";
require_once "InternalErrorException.php";
require_once "MissingEntryException.php";

class SammlungPDOSQLite extends AbstractPDOSQLite implements SammlungDAO
{
    private static SammlungDAO|null $instance = null;

    public static function getInstance(): SammlungDAO
    {
        if (self::$instance == null) {
            self::$instance = new SammlungPDOSQLite();
        }

        return self::$instance;
    }

    public function createBeitrag(int $creator_id, string $title, string $picture, string $description, string $location, string $lat, string $lng): int
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

            $success = $command->execute([":id" => $creator_id]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $sql = "
                INSERT INTO
                    beitrag (title, picture, description, location, lat, lng, creator_id)
                VALUES
                    (:title, :picture, :description, :location, :lat, :lng, :creator_id)
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([
                ":title" => $title,
                ":picture" => $picture,
                ":description" => $description,
                ":location" => $location,
                ":lat" => $lat,
                ":lng" => $lng,
                ":creator_id" => $creator_id,
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

    public function readBeitrag($id): Beitrag
    {
        try {
            $db = $this->getConnection();
            $sql = "
                SELECT 
                    b.id AS beitrag_id,
                    b.title AS beitrag_title,
                    b.picture AS beitrag_picture,
                    b.description AS beitrag_description,
                    b.location AS beitrag_location,
                    b.lat AS beitrag_lat,
                    b.lng AS beitrag_lng,
                    a.id AS creator_id,
                    a.email AS creator_email,
                    a.password AS creator_password
                FROM
                    beitrag b 
                JOIN
                    account a
                ON
                    b.creator_id = a.id
                WHERE
                    b.id = :id;
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id]);
            if (!$success) {
                throw new InternalErrorException();
            }

            $beitrag = null;

            while ($row = $command->fetch(PDO::FETCH_ASSOC)) {
                if ($beitrag === null) {
                    $beitragCreator = new Account(
                        intval($row['creator_id']),
                        $row['creator_email'],
                        $row['creator_password'],
                    );

                    $beitrag = new Beitrag(
                        intval($row['beitrag_id']),
                        $beitragCreator,
                        $row['beitrag_title'],
                        $row['beitrag_picture'],
                        $row['beitrag_description'],
                        $row['beitrag_location'],
                        $row['beitrag_lat'],
                        $row['beitrag_lng']
                    );
                }
            }

            if ($beitrag === null) {
                throw new MissingEntryException();
            }

            return $beitrag;
        } catch (PDOException $exception) {
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    public function updateBeitrag(int $id, int $creator_id, string $title, string $picture, string $description, string $location, string $lat, string $lng): void
    {
        try {
            $db = $this->getConnection();
            $db->beginTransaction();

            //$sql = "SELECT * FROM beitrag WHERE id = :id AND creator_id = :creator_id";
            $sql = "SELECT * FROM beitrag WHERE id = :id";
            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            //$success = $command->execute([":id" => $id, ":creator_id" => $creator_id]);
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

            $sql = "
                UPDATE 
                    beitrag 
                SET 
                    title = :title,
                    picture = :picture,
                    description = :description, 
                    location = :location,
                    lat = :lat,
                    lng = :lng,
                    creator_id = :creator_id
                WHERE 
                    id = :id
                ";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([
                ":id" => $id,
                ":title" => $title,
                ":picture" => $picture === '' ? $result['picture'] : $picture,
                ":description" => $description,
                ":location" => $location,
                ":lat" => $lat,
                ":lng" => $lng,
                ":creator_id" => $creator_id

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
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }

    public function deleteBeitrag($id, int $creator_id): void
    {
        try {
            $db = $this->getConnection();
            $db->beginTransaction();

            $sql = "SELECT * FROM beitrag WHERE id = :id AND creator_id = :creator_id";

            $command = $db->prepare($sql);
            if (!$command) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $success = $command->execute([":id" => $id, ":creator_id" => $creator_id]);
            if (!$success) {
                $db->rollBack();
                throw new InternalErrorException();
            }

            $result = $command->fetch();
            if (empty($result)) {
                $db->rollBack();
                throw new MissingEntryException();
            }

            $sql = "DELETE FROM beitrag WHERE id = :id";
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

    public function readAllBeitraege(): array
    {
        try {
            $db = $this->getConnection();
            $sql = "
                SELECT 
                    b.id AS beitrag_id,
                    b.title AS beitrag_title,
                    b.picture AS beitrag_picture,
                    b.description AS beitrag_description,
                    b.location AS beitrag_location,
                    b.lat AS beitrag_lat,
                    b.lng AS beitrag_lng,
                    a.id AS creator_id,
                    a.email AS creator_email,
                    a.password AS creator_password
                FROM
                    beitrag b 
                JOIN
                    account a
                ON
                    b.creator_id = a.id
            ";

            $command = $db->prepare($sql);
            if (!$command) {
                throw new InternalErrorException();
            }

            $success = $command->execute();
            if (!$success) {
                throw new InternalErrorException();
            }

            $beitraege = [];

            while ($row = $command->fetch(PDO::FETCH_ASSOC)) {
                if (!isset($beitraege[$row['beitrag_id']])) {
                    $beitragCreator = new Account(
                        intval($row['creator_id']),
                        $row['creator_email'],
                        $row['creator_password'],
                    );

                    $beitrag = new Beitrag(
                        intval($row['beitrag_id']),
                        $beitragCreator,
                        $row['beitrag_title'],
                        $row['beitrag_picture'],
                        $row['beitrag_description'],
                        $row['beitrag_location'],
                        $row['beitrag_lat'],
                        $row['beitrag_lng']
                    );

                    $beitraege[$row['beitrag_id']] = $beitrag;
                }
            }

            return $beitraege;
        } catch (PDOException $exception) {
            throw new InternalErrorException($exception->getMessage(), previous: $exception);
        }
    }
}
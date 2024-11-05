<?php

abstract class AbstractPDOSQLite
{
    protected function getConnection(): PDO
    {
        global $abs_path;
        if (!file_exists($abs_path . "/db/OldenburgerSkulpturen.db")) {
            $this->create();
        }

        try {
            return new PDO(sprintf('sqlite:%s/db/OldenburgerSkulpturen.db', $abs_path), 'root', null);
        } catch (PDOException $e) {
            throw new InternalErrorException();
        }
    }

    private function create(): void
    {
        global $abs_path;
        try {
            $db = new PDO(sprintf('sqlite:%s/db/OldenburgerSkulpturen.db', $abs_path), 'root', null);

            $db->exec("
                CREATE TABLE IF NOT EXISTS account (
                    id INTEGER NOT NULL,
                    email TEXT NOT NULL UNIQUE,
                    password TEXT NOT NULL,
                    active INTEGER NOT NULL DEFAULT 0,
                    PRIMARY KEY(id AUTOINCREMENT)
                );
            ");

            $db->exec("
                CREATE TABLE IF NOT EXISTS beitrag (
                    id INTEGER NOT NULL,
                    title TEXT NOT NULL,
                    picture TEXT NOT NULL,
                    description	TEXT NOT NULL,
                    location TEXT NOT NULL,
                    lat TEXT NOT NULL,
                    lng TEXT NOT NULL,
                    creator_id INTEGER NOT NULL,
                    PRIMARY KEY(id AUTOINCREMENT),
                    FOREIGN KEY(creator_id) REFERENCES account(id)
                );
            ");


            /**
             * db mit Dummy-Daten befüllen
             */
            $sql = "
                INSERT INTO account (email, password, active) VALUES
                    (:email0, :password0, :active0),
                    (:email1, :password1, :active1),
                    (:email2, :password2, :active2),
                    (:email3, :password3, :active3),
                    (:email4, :password4, :active4),
                    (:email5, :password5, :active5)
            ";

            $command = $db->prepare($sql);

            $params = [
                ':email0' => 'admin@ol-skulpturen.de',
                ':password0' => password_hash('admin', PASSWORD_DEFAULT),
                ':active0' => 1,

                ':email1' => 'firstUser@mail.de',
                ':password1' => password_hash('geheim', PASSWORD_DEFAULT),
                ':active1' => 1,

                ':email2' => 'secondUser@mail.de',
                ':password2' => password_hash('geheim', PASSWORD_DEFAULT),
                ':active2' => 1,

                ':email3' => 'thirdUser@mail.de',
                ':password3' => password_hash('geheim', PASSWORD_DEFAULT),
                ':active3' => 1,

                ':email4' => 'fourthUser@mail.de',
                ':password4' => password_hash('geheim', PASSWORD_DEFAULT),
                ':active4' => 1,

                ':email5' => 'fifthUser@mail.de',
                ':password5' => password_hash('geheim', PASSWORD_DEFAULT),
                ':active5' => 1,

            ];
            $command->execute($params);

            $sql = "
                INSERT INTO beitrag (title, picture, description, location, lat, lng, creator_id) VALUES 
                    (:title0, :picture0, :description0, :location0, :lat0, :lng0, :creator_id0),
                    (:title1, :picture1, :description1, :location1, :lat1, :lng1, :creator_id1),
                    (:title2, :picture2, :description2, :location2, :lat2, :lng2, :creator_id2),
                    (:title3, :picture3, :description3, :location3, :lat3, :lng3, :creator_id3),
                    (:title4, :picture4, :description4, :location4, :lat4, :lng4, :creator_id4),
                    (:title5, :picture5, :description5, :location5, :lat5, :lng5, :creator_id5),
                    (:title6, :picture6, :description6, :location6, :lat6, :lng6, :creator_id6)
            ";

            $command = $db->prepare($sql);

            /**
             * Daten und Bilder stammen von der Stadt Oldenburg
             * https://gis4ol.oldenburg.de/Stadtplan/index.html?esearch=22&slayer=1
             */
            $params = [
                ':title0' => 'Carl von Ossietzky-Mahnmal',
                ':picture0' => 'assets/media/uploads/b94e5be049fb40f31b646ab99ae5a2fa.jpg',
                ':description0' => 'Künstler: Hans Peter Reinartz; Entstehungsjahr: 1978; Material: polierter nichtrostender Stahl auf Kunststein; Maße: Höhe 2,80 m, Breite 2,90 m, Tiefe 1,80 m; Maße/Sockel: Höhe 0,90 m, Breite 0,61 m, Tiefe 0,61 m; Eigentümer: Land Niedersachsen;',
                ':location0' => 'Uhlhornsweg, 26129 Oldenburg',
                ':lat0' => '53.14751257249286',
                ':lng0' => '8.181753158460197',
                ':creator_id0' =>1,

                ':title1' => 'Der goldborstige Eber',
                ':picture1' => 'assets/media/uploads/a3b08a0cd8772e308924b7fc4737f9e5.jpg',
                ':description1' => 'Künstler: Gerhard Brüning; Entstehungsjahr: 2005; Material: Bronze; Maße: Höhe ca. 1,00 m, Länge ca. 1,50 m, Breite ca. 40 cm; Eigentümer: Stadt Oldenburg;',
                ':location1' => 'Marktplatz Eversten 1, 26122 Oldenburg',
                ':lat1' => '53.133720810862194',
                ':lng1' => '8.19990634907299',
                ':creator_id1' => 1,

                ':title2' => 'Drei Bären',
                ':picture2' => 'assets/media/uploads/0c9b4c80f48d1710f4dbfc03cdfe646c.jpg',
                ':description2' => 'Künstler: Paul Halbhuber; Entstehungsjahr: 1964; Material: Bronze; Maße: Höhe 2,20 m/2,40 m/2,00 m; Eigentümer: Stadt Oldenburg;',
                ':location2' => 'Schloßplatz 3, 26122 Oldenburg',
                ':lat2' => '53.13820699805412',
                ':lng2' => '8.216629028265745',
                ':creator_id2' => 2,

                ':title3' => 'Herzog Peter Friedrich Ludwig',
                ':picture3' => 'assets/media/uploads/8be4bc96cfb1840def0ebbdf734d4b1e.jpg',
                ':description3' => 'Künstler: Karl Gundelach; Entstehungsjahr: 1893; Material: Bronze, Granit; Maße/Figur: Höhe ca. 2,00 m; Maße/Sockel: Höhe 1,80 m, Breite 1,25 m, Tiefe 1,25 m; Eigentümer: Stadt Oldenburg;',
                ':location3' => 'Schlossplatz 10, 26122 Oldenburg',
                ':lat3' => '53.138041804791975',
                ':lng3' => '8.215345144162711',
                ':creator_id3' => 2,

                ':title4' => 'Knabe mit Fisch',
                ':picture4' => 'assets/media/uploads/f06c07fd33e8b5057d888095c7ad390a.jpg',
                ':description4' => 'Künstler: Emil Obermann; Entstehungsjahr: 1900; Material: Bronze; Maße: Höhe 0,85 m, Breite ca. 0,40 m, Tiefe ca. 1,00 m; Eigentümer: Stadt Oldenburg;',
                ':location4' => 'Duvenhorst , 26127 Oldenburg',
                ':lat4' => '53.16776431022799',
                ':lng4' => '8.208882808467024',
                ':creator_id4' => 5,

                ':title5' => 'Mann im Matsch - Der Suchende',
                ':picture5' => 'assets/media/uploads/td2o0v34euh4nb5ccapqx8tag0qu4k88.jpg',
                ':description5' => 'Künstler: Thomas Schütte; Entstehungsjahr: 2009; Material: Bronze (Figur), Sandstein (Brunnenbecken); Maße: Höhe 5,80 m, ø Brunnenbecken ca. 6,00 m; Eigentümer: Landessparkasse zu Oldenburg',
                ':location5' => 'Berliner Platz 1, 26122 Oldenburg',
                ':lat5' => '53.145544',
                ':lng5' => '8.226196',
                ':creator_id5' => 4,

                ':title6' => 'Elefant',
                ':picture6' => 'assets/media/uploads/g8qdx1glrds1dtlf42j0ogcogawz18k2.jpg',
                ':description6' => 'Künstler: Unbekannt; Entstehungsjahr: nach 1968; Material: Lego-Steine; Maße: unbekannt; Eigentümer: Lego A/S, Billund, DK;',
                ':location6' => 'Nordmarksvej 9, 7190 Billund, Dänemark',
                ':lat6' => '55.735704',
                ':lng6' => '9.128603',
                ':creator_id6' => 3
            ];

            $command->execute($params);

            unset($db);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw $e;
            //throw new InternalErrorException();
        }
    }
}
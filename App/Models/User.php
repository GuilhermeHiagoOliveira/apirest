<?php

namespace App\Models;

class User
{
    private static $table = 'user';

    public static function select(int $id)
    {
        $connPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id = :id';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum usuário encontrado!");
        }
    }

    public static function selectAll()
    {
        $connPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table;
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum usuário encontrado!");
        }
    }

    public static function insert($data)
    {
        $connPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'INSERT INTO ' . self::$table . ' (email, password, name) VALUE (:em, :pa, :na)';
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(":em", $data['email']);
        $stmt->bindValue(":pa", $data['password']);
        $stmt->bindValue(":na", $data['name']);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return 'Usuário(a) cadastrado com sucesso!';
            } else {
                throw new \Exception("Falha ao cadastrar usuário(a)!");
            }
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // duplicate entry
                throw new \Exception('Falha ao cadastrar usuário(a)!');
            } else {
                // an error other than duplicate entry occurred
            }
        }
    }
}

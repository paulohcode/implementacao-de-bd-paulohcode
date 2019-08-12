<?php

declare(strict_types=1);

require_once 'Abstraction/BancoDeDados.php';
require_once 'Config/Config.php';

class BancoDeDados implements \PosAlfa\Abstraction\BancoDeDados
{

    const DSN = DB_HOST;
    const USER = DB_USER;
    const PASS = DB_PASS;

    public $id;
    public $nome;
    public $sobrenome;

    public function getID()
    {
        return $this->id;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSobreNome()
    {
        return $this->sobrenome;
    }

    public function setSobreNome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }

    public function connect(string $dsn, string $user, string $pass): \PDO
    {
        $conn = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE  => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_CASE     => \PDO::CASE_LOWER
        ]);
        return $conn;
    }

    public function prepare(\PDO $pdo, string $sql): \PDOStatement
    {
        return $pdo->prepare($sql);
    }

    public function selectAll()
    {
        try {
            $pdo = $this->connect(self::DSN, self::USER, self::PASS);
            $stmt = $this->prepare($pdo, 'SELECT * FROM aluno');
            $stmt->execute();
            while ($result = $stmt->fetch(PDO::FETCH_OBJ)){
                $id = $result->id;
                $nome = $result->nome;
                $sobrenome = $result->sobrenome;

                echo '<tr><td>'.$id.'</td>
                <td>'.$nome.'</td>
                <td>'.$sobrenome.'</td></tr>';

            };
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    
}

    // private  $instance;

    // public  function getInstance(){
    //     if(!isset(self::$instance))
    //     {
    //         try {
    //             self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    //             self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //             self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    //         } catch(PDOException $e) {
    //             echo $e->getMessage();
    //         }
    //     }

    //     return self::$instance;
    // }

    // public  function prepare($sql)
    // {
    //     return self::getInstance()->prepare($sql);    
    // }

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDO;
use PDOException;

class SimpleLogOld extends Controller
{
    public function buscarTransportadora($cnpj)
    {
        $hostname = '50.6.138.59';
        $username = 'sim09942_Edwalbert';
        $password = 'jve?6!7G2RMi';
        $database = 'sim09942_cadastro';

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "SELECT * FROM transp WHERE cnpj = $cnpj";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                return response()->json(['data' => $results]);
            } else {
                return response()->json(['error' => 'Registro não encontrado'], 404);
            }
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function buscarCavalo($placa)
    {
        $hostname = '50.6.138.59';
        $username = 'sim09942_Edwalbert';
        $password = 'jve?6!7G2RMi';
        $database = 'sim09942_cadastro';

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "SELECT * FROM cavalo WHERE placa = '$placa'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                return response()->json(['data' => $results]);
            } else {
                return response()->json(['error' => 'Registro não encontrado'], 404);
            }
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function buscarMotorista($cpf)
    {
        $hostname = '50.6.138.59';
        $username = 'sim09942_Edwalbert';
        $password = 'jve?6!7G2RMi';
        $database = 'sim09942_cadastro';

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "SELECT * FROM motorista WHERE cpf = '$cpf'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


            if ($results) {
                return response()->json(['data' => $results]);
            } else {
                return response()->json(['error' => 'Registro não encontrado'], 404);
            }
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }


    public function buscarCarreta($placa)
    {
        $hostname = '50.6.138.59';
        $username = 'sim09942_Edwalbert';
        $password = 'jve?6!7G2RMi';
        $database = 'sim09942_cadastro';

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "SELECT * FROM carreta WHERE placa_cr = '$placa'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                return response()->json(['data' => $results]);
            } else {
                return response()->json(['error' => 'Registro não encontrado'], 404);
            }
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}

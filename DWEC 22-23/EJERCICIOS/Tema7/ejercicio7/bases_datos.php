<?php

class AccesoDatos{

    const HOST = "localhost";
    const USUARIO = "arturo";
    const PASSWORD = "arturo12345";
    const DBNAME = "formjs71";
    
    private PDO $conn;

    private static AccesoDatos $datos;

    public static function getSingletone(){
        if(!isset($datos)){
            self::$datos = new AccesoDatos();
        }
        
        return self::$datos;
    }
    


    private function __construct(){

        try {
            /**
             * Abrir conexion a base de datos.
            */
            $this->conn = new PDO('mysql:host='. self::HOST .';dbname='. self::DBNAME ,self::USUARIO, self::PASSWORD);
        
            /**
             * Añadimos atributos a la conexion. Lanza excepciones cuando falle y el Fetch te devuelve arrays asociativos.
             */
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "\n";
            die();
        }
    }

    //Devielve array con todos los ciclistas que van en arrays asociativos
    public function findAllCiclistas() : array{

        $ciclistas = [];

        try {
            /**
             * Preparar la consulta
            */
            $stmt = $this->conn->prepare('SELECT * FROM Ciclistas');
        
            /**
             * Ejecutamos la consulta
            */
            if($stmt->execute()){
                $ciclistas = $stmt->fetchAll();
            }else{
                //Not good
            }
        } catch (\Throwable $th) {
            //Excapcion al hacer la consulta
        }

        return $ciclistas;
    }
    
    /**
     * Devuelve el ciclista con el id selecionado
     */
    public function findCiclistaById(int $id){

        $ciclista = [];

        try {
        
            $stmt = $this->conn->prepare('SELECT * FROM Ciclistas WHERE id = :id' );
        
            if($stmt->execute(
                array(':id' => $id)
            )){

                $ciclista = $stmt->fetchAll();
    
            }else{
                //Not good
            }


        } catch (\Throwable $th) {
            //Excapcion al hacer la consulta
        }

        return $ciclista;
    }

    public function insertCiclista(array $parametros){

        $exito = false;

        try {
        
            $stmt = $this->conn->prepare('INSERT INTO Ciclistas(nombre,num_trofeos) VALUES (:nombre,:num_trofeos)' );
        
            $exito = $stmt->execute(
                array(
                    ':nombre' => $parametros['nombre'],
                    ':num_trofeos' => $parametros['num_trofeos']
                )
            );

        } catch (\Throwable $th) {
            //Excapcion al hacer la consulta
        }

        return $exito;
    }

    public function deleteCiclistaByID(int $id){

        $ciclista = [];

        try {
        
            $stmt = $this->conn->prepare('DELETE FROM Ciclistas WHERE id = :id' );
        
            if($stmt->execute(
                array(':id' => $id)
            )){

                $ciclista = $stmt->fetchAll();
    
            }else{
                //Not good
            }


        } catch (\Throwable $th) {
            //Excapcion al hacer la consulta
        }

        return $ciclista;
    }

    public function insertDatos(array $parametros){

        $exito = false;

        try {
        
            $stmt = $this->conn->prepare('INSERT INTO user(dni, nombre, apellido, estudios) VALUES (:dni, :nombre, :apellido, :estudios)' );
        
            $exito = $stmt->execute(
                array(
                    ':dni' => $parametros['dni'],
                    ':nombre' => $parametros['nombre'],
                    ':apellido' => $parametros['apellido'],
                    ':estudios' => $parametros['estudios'],
                )
            );

        } catch (\Throwable $th) {
           
        }

        return $exito;
    }
    
    public function deleteUser(string $parametros) : bool{

        $exito = false;

        try {

            $stmt = $this->conn->prepare("
                DELETE FROM registro WHERE dni = :dni
            ");

            $a = array(
                ':dni' => $parametros
            );
            $exito = $stmt->execute($a);

        } catch (\Throwable $th) {
            throw $th;
        }

        return $exito;
    }

    public function eliminarUser(string $bdni){

        $user = [];
        
        try {
        
            $stmt = $this->conn->prepare('DELETE FROM user WHERE dni = :dni' );
        
            if($stmt->execute(
                array(':dni' => $bdni)
            )){
        
                $user = $stmt->fetchAll();
        
            }else{
                //Not good
            }
        
        
        } catch (\Throwable $th) {
            //Excepcion al hacer la consulta
        }
        
        return $user;
        }
}

/*
$a = AccesoDatos::getSingletone();

echo "<pre>";

print_r($a->findAllCiclistas());

echo "</pre>";

echo "<pre>";

print_r($a->findCiclistaById(4));

echo "</pre>";

echo "<pre>";

print_r($a->insertCiclista(
    array (
        "nombre" => "Pepe",
        "num_trofeos" => 16
    )
));

echo "</pre>";

echo "<pre>";

print_r($a->deleteCiclistaByID(4));
    

echo "</pre>";

echo "<pre>";

print_r($a->findAllCiclistas());

echo "</pre>";
*/
?>
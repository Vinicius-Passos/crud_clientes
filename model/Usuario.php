<?php
require_once("Funcoes.php");
#region USUARIO
class Usuario 
{
    public $_idusuario;
    public $_email;
    public $_senha;
    public $_nome;
    private $_conn;

    #region CONSTRUTOR
    public function __construct($params, ConexaoInterface $conn)
    {
        $this->_conn = $conn;
        $this->_idusuario = isset($params["idusuario"]) ? $params["idusuario"] : NULL;
        $this->_email = isset($params["emailusuario"]) ? $params["emailusuario"] : NULL;
        $this->_senha = isset($params["senhausuario"]) ? $params["senhausuario"] : NULL;
        $this->_nome = isset($params["nomeusuario"]) ? $params["nomeusuario"] : NULL;
    }
    #endregion

    #region LOGIN
    public function login()
    {
        $ur = new UsuarioRepository($this->_conn);

        $usuario_db = new Usuario($ur->selectEmailUsuario($this->_email), $this->_conn);
        
        if($usuario_db->_email != null && password_verify($this->_senha, $usuario_db->_senha))
        {
            session_start();
            $_SESSION["login"] = $usuario_db->_email;
            $_SESSION["nomeUsuario"] = $usuario_db->_nome;
            
            return true;
        }
        else
        {
            session_start();
            session_destroy();
            
            return false;
        }
    }
    #endregion
}
#endregion

#region USUARIO REPOSITORY
class UsuarioRepository
{
    #region PROPRIEDADES PRIVADAS
    private $_conn;
    #endregion

    #region CONSTRUTOR
    public function __construct(ConexaoInterface $conn)
    {
        $this->_conn = $conn;
    }
    #endregion

    #region INSERT
    public function insert()
    {
        // INSERÇÃO
    }
    #endregion

    #region DELETE
    public function delete()
    {
        // EXCLUSÃO
    }
    #endregion

    #region UPDATE
    public function update()
    {
        // ALTERAÇÃO
    }
    #endregion

    #region SELECT
    public function select()
    {
        return "&SELECT& 
                        usuario.idusuario
                       ,usuario.nomeusuario
                       ,usuario.emailusuario
                       ,usuario.senhausuario
                    FROM 
                        &usuario&";        
    }
    #endregion

    #region SELECT POR EMAIL
    public function selectEmailUsuario($emailusuario)
    {
        $query = $this->select();
        $conexao = $this->_conn->conecta();

        $query = str_replace("&SELECT&", "SELECT", $query);
        $query = str_replace("&usuario&", "usuario WHERE emailusuario = ?", $query);
        
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(1, $emailusuario);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // FECHA CONEXÃO
        $this->_conn = null;
        $conexao = null;

        return $resultado;
    }
    #endregion

    #region SELECT POR ID
    public function selectByIdUsuario($idusuario)
    {
        $query = $this->select();
        $query = str_replace("&SELECT&", "SELECT", $query);
        $query = str_replace("&usuario&", "usuario WHERE idusuario = ?", $query);
        
        $stmt = mysqli_prepare($this->_conn, $query);
        $stmt->bind_param("i", $idusuario);
        $stmt->execute();
        $resultado = mysqli_fetch_assoc($stmt->get_result());
        $stmt->close();

        var_dump($resultado);

        return $resultado;
    }
    #endregion
}
#endregion USUARIO REPOSITORY

#region UsuarioViewer
class UsuarioViewer
{

}
#endregion
?>
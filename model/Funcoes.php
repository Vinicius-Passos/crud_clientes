<?php
class Funcoes
{
    public function redireciona($url, $values)
    {
        header("Location: ".$url);
    }

    public function filtraCampos($campo, $tipoCampo)
    {
        switch($tipoCampo)
        {
            case 1://FILTRAR E-MAIL
                $campo = filter_var($campo, FILTER_SANITIZE_EMAIL);
                break;
            case 2://FILTRA CAMPOS PADRÃO DE TEXTO
                $campo = filter_var($campo, FILTER_SANITIZE_STRING);
                $campo = strtoupper($campo);
                break;
            case 3://FILTRA INT
                $campo = filter_var($campo, FILTER_SANITIZE_NUMBER_INT);
                break;
            case 4://FILTRA FLOAT
                $campo = filter_var($campo, FILTER_SANITIZE_NUMBER_FLOAT);
                break;
            case 5://FILTRA DATA (dd/mm/YYYY) -> (YYYY-mm-dd)
                $campo = explode($campo, "/");
                $campo = $campo[2] . "-" . $campo[1] . "-" . $campo[0];
                break;
            default:
                $campo = filter_var($campo, FILTER_SANITIZE_STRING);
                $campo = strtoupper($campo);
                break;
        }

        return $campo;
    }

    public function logado()
    {
        session_start();
        $funcoes = new Funcoes();
        $_SESSION["login"] != null
            ? true
            : $funcoes->redireciona("http://localhost/vemprakabum_proj/login", []);
    }
}
?>
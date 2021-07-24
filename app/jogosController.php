<?php

class jogosController{

    private $qtdDezenas;

    private $resultado = [];

    private $totalJogos;

    private $jogos;


    public function getQtdDezenas(){
        return $this->qtdDezenas;
    }

    public function getResultado(){
        return $this->resultado;
    }
    public function getTotalJogos(){
        return $this->totalJogos;
    }

    public function getJogos(){
        return $this->jogos;
    }

    public function setQtdDezenas($qtdDezenas){
        if($qtdDezenas < 6 || $qtdDezenas > 10){
           echo '<div align="center" style="margin-bottom:15px;"><h2>Quantidade de dezenas informada está incorreta. <br/>Permitidos somente 6, 7, 8, 9 ou 10 <h2></div>';
           exit;
        }
        $this->qtdDezenas = $qtdDezenas;
    }

    public function setResultado($resultado){
        $this->resultado = $resultado;
    }
    public function setTotalJogos($totalJogos){
        $this->totalJogos = $totalJogos;
    }
    public function setJogos($jogos){
        $this->jogos = $jogos;
    }


    public function __construct($qtdDezenas, $totalJogos)
    {
        $this->setQtdDezenas($qtdDezenas);
        $this->setTotalJogos($totalJogos);
    }


    private function sortearJogo(){
        $matriz      = array();
        $i = 1;
        while($i <= $this->qtdDezenas){
            $rand = mt_rand(1, 60);  // sorteia um número entre 1 até 60
            if(!in_array($rand, $matriz))  // SE os 6 números da mega sena NÃO FOREM IGUAIS ENTÃO
            {
                $matriz[$i] = $rand;
                $i++;
            }
        }
        sort($matriz);
        return ($matriz);
    }

    public function montarCartela(){
        for($i = 1; $i <= $this->totalJogos; $i++){
            $this->jogos[$i] = $this->sortearJogo();
        }
    }

    public function sortear(){
        $i = 0; 
        while($i < 6){
            $rand = mt_rand(1, 60);  // sorteia um número entre 1 até 60
            if(!in_array($rand, $this->resultado))  // SE os 6 números da mega sena NÃO FOREM IGUAIS ENTÃO
            {
                $this->resultado[$i] = $rand;
                $i++;
            }
        }
        return sort($this->resultado);
    }

    public function conferirJogo(){
        foreach($this->resultado as $numeroSorteado){
            foreach($this->jogos as $indice => $jogo){
                sort($jogo);
                foreach($jogo as $indiceJogo => $numeroJogado){
                    if($numeroJogado == $numeroSorteado){
                        $jogo[$indiceJogo] = $numeroSorteado . '-P';
                    }
                }
                $this->jogos[$indice] = $jogo;
            }
        }
        return;
    }

    public function montarTabelaResultados(){
        $apresentarResultado = '';
        foreach($this->jogos as $indice => $jogo){
            sort($jogo);
            $apresentarResultado .= '<table border="0" align="center" style="margin-bottom:15px;">';
            $apresentarResultado .= '<tbody><tr>';
            $apresentarResultado .= '<td colspan="'. $this->qtdDezenas .'"><div align="center"><strong>Cartela ' . ($indice) . ' </strong></div></td>';
            $apresentarResultado .= '</tr>';
            $apresentarResultado .= '<tr>';
            foreach($jogo as $numeroJogado){
                $resultado = explode('-', $numeroJogado);
                if(count($resultado) > 1){
                    $apresentarResultado .= '<td width="45" height="45" style="background-image:url(../img/premiado.png); background-repeat:no-repeat"><div align="center" style="color:#000000; font-weight:bold; font-size:16px">'. $resultado[0].'</div></td>';
                }else{
                    $apresentarResultado .= '<td width="45" height="45" style="background-image:url(../img/notresult.png); background-repeat:no-repeat"><div align="center" style="color:#000000; font-weight:bold; font-size:16px">'. $resultado[0].'</div></td>';
                }
            }
            $apresentarResultado .= '</tr>';
            $apresentarResultado .= '</tbody></table>';
        }

        $apresentarResultado .= '<br/>';
        $apresentarResultado .= '<br/>';
        $apresentarResultado .= '<br/>';
        $apresentarResultado .= '<table border="0" align="center" style="margin-bottom:15px;">';
        $apresentarResultado .= '<tbody><tr>';
        $apresentarResultado .= '<td colspan="'.$this->qtdDezenas.'"><div align="center"><strong>Números Sorteados ' . ' (' .date('d/m/Y') . ')</strong></div></td>';
        $apresentarResultado .= '</tr>';
        $apresentarResultado .= '<tr>';
        foreach($this->resultado as $numeroSorteado){
            $apresentarResultado .= '<td width="45" height="45" style="background-image:url(../img/premiado.png); background-repeat:no-repeat"><div align="center" style="color:#000000; font-weight:bold; font-size:16px">'.$numeroSorteado.'</div></td>';
        }
        $apresentarResultado .= '</tr>';
        $apresentarResultado .= '</tbody></table>';
        echo $apresentarResultado;
    }
}

$teste = new jogosController(10, 5);
$teste->montarCartela();
$teste->sortear();
$teste->conferirJogo();
echo '<div align="center" style="margin-bottom:15px;" ><h2>Pressione F5 para gerar um novo jogo</h2> </div>';
$teste->montarTabelaResultados();




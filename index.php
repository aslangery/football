<?php
function match($id1,$id2)
{
    include 'data.php';
    //Создание объектов команд
    $team1=new Team($data[$id1]);
    $team2=new Team($data[$id2]);
    //Подсчет разницы очков атаки и защиты команд, 
    //с выбором случайного значения из промежутка
    $points1max=$team1->power['attack']['max']-$team2->power['defence']['min'];
    $points1min=$team1->power['attack']['average']-$team2->power['defence']['average'];
    $points1= mt_rand((int)$points1min, (int)$points1max);
    $points2max=$team2->power['attack']['max']-$team1->power['defence']['min'];
    $points2min=$team2->power['attack']['average']-$team1->power['defence']['average'];
    $points2= mt_rand((int)$points2min, (int)$points2max);
    
    //подсчет результата матча
    $result[0]=abs(round(($team1->goalsPerMatch['scored']['max']+
            $team1->goalsPerMatch['scored']['average']+
            $team2->goalsPerMatch['skiped']['max']+
            $team2->goalsPerMatch['skiped']['average'])*$points1/400,0));
    $result[1]=abs(round(($team2->goalsPerMatch['scored']['max']+
            $team2->goalsPerMatch['scored']['average']+
            $team1->goalsPerMatch['skiped']['max']+
            $team1->goalsPerMatch['skiped']['average'])*$points2/400,0));
    return $result;
}

class Team{
    protected $results=array();
    
    public $power=array();
    
    public $goalsPerMatch=array();
    
    public function __construct($data)
    {
        $this->results=$data;
        $this->power=$this->calculatePower();
    }
    protected function calculatePower()
    {
        //Подсчет среднего и максимального количества забитых и пропущенных мячей
        $this->goalsPerMatch['scored']['max']=$this->results['goals']['scored']/$this->results['win'];
        $this->goalsPerMatch['scored']['average']=$this->results['goals']['scored']/$this->results['games'];
        $this->goalsPerMatch['skiped']['max']=$this->results['goals']['skiped']/$this->results['defeat'];
        $this->goalsPerMatch['skiped']['average']=$this->results['goals']['skiped']/$this->results['games'];
        //Подсчет мощности атаки и защиты
        $power['attack']['max']=ceil(100*$this->goalsPerMatch['scored']['max']*$this->results['win']/$this->results['games']);
        $power['attack']['average']=floor(100*$this->goalsPerMatch['scored']['average']*$this->results['win']/$this->results['games']);
        $power['defence']['min']=floor(100*(1-$this->goalsPerMatch['skiped']['max']*$this->results['defeat']/$this->results['games']));
        $power['defence']['average']=ceil(100*(1-$this->goalsPerMatch['skiped']['average']*$this->results['defeat']/$this->results['games']));
        return $power;
    }
}
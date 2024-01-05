<?php
    class Player{
        private $yr;
        private $lg;
        private $team;
        private $name;
        private $pos;
        private $age;
        private $exp;

        private $orb;
        private $drb;
        private $trb;
        private $ast;
        private $stl;
        private $blk;
        private $tov;
        private $pf;
        private $pts;

        private $fg;
        private $fga;
        private $fgp;
        private $pt_3;
        private $pt_3a;
        private $pt_3p;
        private $pt_2;
        private $pt_2a;
        private $pt_2p;
        private $tp;
        private $ft;
        private $fta;
        private $ftp;

        function setPlayer_1($row){ //player_info
            $this->yr = $row["year"];
            $this->lg = $row["league"];
            $this->team = $row["team"];
            $this->name = $row["name"];
            $this->pos = $row["pos"];
            $this->age = $row["age"];
            $this->exp = $row["experience"];
        }

        function setPlayer_2($row){ //player_basic
            $this->yr = $row["year"];
            $this->team = $row["team"];
            $this->name = $row["name"];
            
            $this->orb = $row["offensive_rebound"];
            $this->drb = $row["defensive_rebound"];
            $this->trb = $row["total_rebound"];
            $this->ast = $row["assist"];
            $this->stl = $row["steal"];
            $this->blk = $row["block"];
            $this->tov = $row["turnover"];
            $this->pf = $row["personal_foul"];
            $this->pts = $row["points"];
        }

        function setPlayer_3($row){ //player_shooting
            $this->yr = $row["year"];
            $this->team = $row["team"];
            $this->name = $row["name"];

            $this->fg = $row["field_goal"];
            $this->fga = $row["field_goal_attempt"];
            $this->fgp = $row["field_goal_percent"];
            $this->pt_3 = $row["three_point"];
            $this->pt_3a = $row["three_point_attempt"];
            $this->pt_3p = $row["three_point_percent"];
            $this->pt_2 = $row["two_point"];
            $this->pt_2a = $row["two_point_attempt"];
            $this->pt_2p = $row["two_point_percent"];
            $this->tp = $row["true_shooting_percent"];
            $this->ft = $row["free_throw"];
            $this->fta = $row["free_throw_attempt"];
            $this->ftp= $row["free_throw_percent"];
        }


        function getPlayer_1(){ //["year","league","team","name","pos","age","exp"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->lg;
            $row[2]=$this->team;
            $row[3]=$this->name;
            $row[4]=$this->pos;
            $row[5]=$this->age;
            $row[6]=$this->exp;
            return $row;
        }

        function getPlayer_2(){ //["year","team","name","offensive_rebound","defensive_rebound","total_rebound","assist","steal","block","turnover","personal_foul","points"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->team;
            $row[2]=$this->name;
            $row[3]=$this->orb;
            $row[4]=$this->drb;
            $row[5]=$this->trb;
            $row[6]=$this->ast;
            $row[7]=$this->stl;
            $row[8]=$this->blk;
            $row[9]=$this->tov;
            $row[10]=$this->pf;
            $row[11]=$this->pts;
            return $row;
        }

        function getPlayer_3(){ //["year","team","name","true_shooting_percent","field_goal","field_goal_attempt","field_goal_percent","3_point","3_point_attempt","3_point_percent","2_point","2_point_attempt","2_point_percent","free_throw","free_throw_attempt","free_throw_percent"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->team;
            $row[2]=$this->name;
            $row[3]=$this->tp;
            $row[4]=$this->fg;
            $row[5]=$this->fga;
            $row[6]=$this->fgp;
            $row[7]=$this->pt_3;
            $row[8]=$this->pt_3a;
            $row[9]=$this->pt_3p;
            $row[10]=$this->pt_2;
            $row[11]=$this->pt_2a;
            $row[12]=$this->pt_2p;
            $row[13]=$this->ft;
            $row[14]=$this->fta;
            $row[15]=$this->ftp;
            return $row;
        }

    }
?>
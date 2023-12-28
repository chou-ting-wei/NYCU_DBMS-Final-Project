<?php
    class Team{
        private $yr;
        private $lg;
        private $team;
        private $poff;
        private $abbrev;
        private $win;
        private $lose;
        private $arena;
        private $avg_age;
        private $mov;
        private $or;
        private $dr;
        private $pace;
        private $tid;

        private $fg;
        private $fga;
        private $fgp;
        private $pt_3;
        private $pt_3a;
        private $pt_3p;
        private $pt_2;
        private $pt_2a;
        private $pt_2p;
        private $ft;
        private $fta;
        private $ftp;
        private $orb;
        private $drb;
        private $trb;
        private $ast;
        private $stl;
        private $blk;
        private $tov;
        private $pf;
        private $pts;


        function setTeam_1($row){
            $this->yr = $row["year"];
            $this->lg = $row["league"];
            $this->team = $row["team"];
            $this->poff = $row["playoff"];
            $this->abbrev = $row["abbrev"];
            $this->win = $row["win"];
            $this->lose = $row["lose"];
            $this->arena = $row["arena"];
            $this->avg_age = $row["avg_age"];
            $this->mov = $row["margin_of_victory"];
            $this->or = $row["offensive_rating"];
            $this->dr = $row["defensive_rating"];
            $this->pace = $row["pace"];
        }

        function setTeam_2_3_4($row){
            $this->yr = $row["year"];
            $this->lg = $row["league"];
            $this->team = $row["team"];
            $this->poff = $row["playoff"];
            $this->abbrev = $row["abbrev"];
            $this->fg = $row["field_goal"];
            $this->fga = $row["field_goal_attempt"];
            $this->fgp = $row["field_goal_percent"];
            $this->pt_3 = $row["3_point"];
            $this->pt_3a = $row["3_point_attempt"];
            $this->pt_3p = $row["3_point_percent"];
            $this->pt_2 = $row["2_point"];
            $this->pt_2a = $row["2_point_attempt"];
            $this->pt_2p = $row["2_point_percent"];
            $this->ft = $row["free_throw"];
            $this->fta = $row["free_throw_attempt"];
            $this->ftp= $row["free_throw_percent"];
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
        
        
        function getTeam_1(){ //["year","league","team","abbrev","arena","avg_age","win","lose","playoff","margin_of_victory","offensive_rating","defensive_rating","pace"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->lg;
            $row[2]=$this->team;
            $row[3]=$this->abbrev;
            $row[4]=$this->arena;
            $row[5]=$this->avg_age;
            $row[6]=$this->win;
            $row[7]=$this->lose;
            $row[8]=$this->poff;
            $row[9]=$this->mov;
            $row[10]=$this->or;
            $row[11]=$this->dr;
            $row[12]=$this->pace;
            return $row;
        }
        function getTeam_2(){ //["year","league","team","abbrev","field_goal_percent","3_point_percent","2_point_percent","free_throw_percent"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->lg;
            $row[2]=$this->team;
            $row[3]=$this->abbrev;
            $row[4]=$this->fgp;
            $row[5]=$this->pt_3p;
            $row[6]=$this->pt_2p;
            $row[7]=$this->ftp;
            return $row;
        }
        function getTeam_3(){ //["year","league","team","abbrev","field_goal","field_goal_attempt","field_goal_percent","3_point","3_point_attempt","3_point_percent","2_point","2_point_attempt","2_point_percent","free_throw","free_throw_attempt","free_throw_percent"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->lg;
            $row[2]=$this->team;
            $row[3]=$this->abbrev;
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
        function getTeam_4(){ //["year","league","team","abbrev","offensive_rebound","defensive_rebound","total_rebound","assist","steal","block","turnover","personal_foul","points"]
            $row=NULL;
            $row[0]=$this->yr;
            $row[1]=$this->lg;
            $row[2]=$this->team;
            $row[3]=$this->abbrev;
            $row[4]=$this->orb;
            $row[5]=$this->drb;
            $row[6]=$this->trb;
            $row[7]=$this->ast;
            $row[8]=$this->stl;
            $row[9]=$this->blk;
            $row[10]=$this->tov;
            $row[11]=$this->pf;
            $row[12]=$this->pts;
        }
    }
?>
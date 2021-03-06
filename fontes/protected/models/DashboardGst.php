<?php
/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 28/10/16
 * Time: 10:45
 */

/**
 * Dashboard class
 * This class is SQL commands for Dashboard(index) page
 *
 */
class DashboardGst extends CFormModel
{

    public $dtInicial;
    public $dtFinal;
    public $ticketsAbertos;
    public $ticketsAbertosFila;
    public $ticketsEncerrados;
    public $ticketsEncerradosFila;
    public $userId;
    public $tipo;


    /**
     * Valida data de Início e Término
     * @param type $attribute
     * @param type $params
     */
    public function validarPeriodo($attribute, $params)
    {
        if (!empty($this->dtInicial) && !empty($this->dtFinal)) {
            $dt1 = new DateTime(FksFormatter::formatarDateToSQLDate($this->dtInicial));
            $dt2 = new DateTime(FksFormatter::formatarDateToSQLDate($this->dtFinal));
            if ($dt1 > $dt2) {
                $this->addError($attribute, 'Data de Término deve ser maior que Data de Início!');
            }
        }
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dtInicial, dtFinal', 'required', 'on' => 'search'),
            array('dtInicial, dtFinal, tipo', 'required', 'on' => 'report'),
            array('dtFinal', 'validarPeriodo'),
            array('dtInicial, dtFinal, tipo, userId, userFullName', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'dtInicial' => 'Início',
            'dtFinal' => 'Término',
            'userId' => 'Atendente',
            'userFullName' => 'Atendente',
        );
    }

    /**
     * @internal Retorna a quantidade de tickets encerrados
     * @return integer Quantidade de tickets
     * @param null
     * @author Franklin Farias
     *
     */
    public function dash01Stats()
    {
        $sDate = " '" . FksFormatter::StrToDate($this->dtInicial) . "' and '" .
            FksFormatter::StrToDate($this->dtFinal) . "' ";
        $sql = "select * " .
            "from ( " .
            "select count(t.id) as dash01_qtd_aberto  " .
            "from ticket t " .
            "where date(t.create_time) between $sDate " .
            ")t1,( " .
            "select count(t.ticket_id) as dash01_qtd_fechado " .
            "from vw_tickets_encerrados t " .
            "where date(t.finish_time) between $sDate " .
            ")t2";
        $resultSet = Yii::app()->dbCVM->createCommand($sql)->queryAll();

        return $resultSet;
    }

    /**
     * @internal Retorna a quantidade de tickets encerrados GST
     * @return integer Quantidade de tickets
     * @param null
     * @author Leonardo
     *
     */
    public function dashGeralGST()
    {
        {
            $sDate = " '" . FksFormatter::StrToDate($this->dtInicial) . "' and '" .
                FksFormatter::StrToDate($this->dtFinal) . "' ";

            $sql = "SELECT * FROM(SELECT COUNT(*) AS dash02_qtd_aberto FROM vw_first_move fh
            JOIN ticket_history th ON (fh.history_id = th.id AND th.queue_id IN (5,14,15,16))
            WHERE DATE(th.create_time) BETWEEN $sDate) t1,
           (SELECT COUNT(t.ticket_id) AS dash02_qtd_fechado
            FROM vw_tickets_encerrados t
            WHERE DATE(t.finish_time) BETWEEN $sDate
            AND t.queue_finish IN (5,14,15,16)) t2;";

            $resultSet = Yii::app()->dbCVM->createCommand($sql)->queryAll();
            return $resultSet;
        }
    }

    /**
     * @internal Retorna a quantidade de tickets encerrados SSI
     * @return integer Quantidade de tickets
     * @param null
     * @author Leonardo
     *
     */
    public function dashGeralSSI()
    {
        {
            $sDate = " '" . FksFormatter::StrToDate($this->dtInicial) . "' and '" .
                FksFormatter::StrToDate($this->dtFinal) . "' ";

            $sql = "SELECT * FROM(SELECT COUNT(*) AS dash03_qtd_aberto FROM vw_first_move fh
            JOIN ticket_history th ON (fh.history_id = th.id AND th.queue_id IN (6))
            WHERE DATE(th.create_time) BETWEEN $sDate) t1,
           (SELECT COUNT(t.ticket_id) AS dash03_qtd_fechado
            FROM vw_tickets_encerrados t
            WHERE DATE(t.finish_time) BETWEEN $sDate
            AND t.queue_finish IN (6)) t2;";

            $resultSet = Yii::app()->dbCVM->createCommand($sql)->queryAll();
            return $resultSet;
        }
    }

    /**
     * @internal Retorna a quantidade de tickets encerrados SEI
     * @return integer Quantidade de tickets
     * @param null
     * @author Franklin Farias
     *
     */
    public function dashGeralSEI()
    {
        {
            $sDate = " '" . FksFormatter::StrToDate($this->dtInicial) . "' and '" .
                FksFormatter::StrToDate($this->dtFinal) . "' ";

            $sql = "SELECT * FROM(SELECT COUNT(*) AS dash04_qtd_aberto FROM vw_first_move fh
            JOIN ticket_history th ON (fh.history_id = th.id AND th.queue_id IN (21))
            WHERE DATE(th.create_time) BETWEEN $sDate) t1,
           (SELECT COUNT(t.ticket_id) AS dash04_qtd_fechado
            FROM vw_tickets_encerrados t
            WHERE DATE(t.finish_time) BETWEEN $sDate
            AND t.queue_finish IN (21)) t2;";

            $resultSet = Yii::app()->dbCVM->createCommand($sql)->queryAll();
            return $resultSet;
        }
    }

    /**
     * @internal Retorna estatistica dos Agentes TOP 10 GST
     * @return array
     * @param null
     * @author Franklin Farias
     *
     */
    public function dashEstatAgentesGST()
    {
        $sDate = " '" . FksFormatter::StrToDate($this->dtInicial) . "' and '" .
            FksFormatter::StrToDate($this->dtFinal) . "' ";
        $sql = "select " .
            "u.id, concat(u.first_name,' ',u.last_name) as user_name, " .
            "tb1.qtd as qtd_create, " .
            "tb2.qtd as qtd_closed, " .
            "tb3.qtd as qtd_aberto, " .
            "tb4.qtd as qtd_andamento, " .
            "tb5.qtd as qtd_pendente, " .
            "tb6.qtd as qtd_resolvido, " .
            "'<span class=\"inlinebar\">1,3,4,5,3,5</span>' as stat " .
            "from users u " .
            "left join ( " .
            "select create_by as user_id, count(*) as qtd " .
            "from ticket  " .
            "where DATE(create_time) BETWEEN  $sDate" .
            "group by create_by) as tb1 ON u.id = tb1.user_id " .
            "left join ( " .
            "select user_finish, count(*) as qtd " .
            "from vw_tickets_encerrados  " .
            "where DATE(finish_time) BETWEEN $sDate" .
            "group by user_finish) as tb2 ON u.id = tb2.user_finish " .
            "left join ( " .
            "select user_id, count(*) as qtd " .
            "from ticket " .
            "where ticket_state_id = 4 AND DATE(change_time) BETWEEN  $sDate"  .
            "group by user_id) as tb3 ON u.id = tb3.user_id " .
            "left join ( " .
            "select user_id, count(*) as qtd " .
            "from ticket " .
            "where ticket_state_id = 2 AND DATE(change_time) BETWEEN $sDate"  .
            "group by user_id) as tb4 ON u.id = tb4.user_id " .
            "left join ( " .
            "select user_id, count(*) as qtd " .
            "from ticket " .
            "where ticket_state_id = 6 AND DATE(change_time) BETWEEN $sDate"  .
            "group by user_id) as tb5 ON u.id = tb5.user_id " .
            "left join ( " .
            "select user_id, count(*) as qtd " .
            "from ticket " .
            "where ticket_state_id = 3 AND DATE(change_time) BETWEEN $sDate"  .
            "group by user_id) as tb6 ON u.id = tb6.user_id " .
            "where u.id IN (select user_id from vw_user_roles where role_id = 5) " .
            "order by (coalesce(tb1.qtd,0) + coalesce(tb2.qtd,0)) DESC ";
        $resultSet = Yii::app()->dbCVM->createCommand($sql)->queryAll();

        return $resultSet;
    }


    /**
     * @internal Retorna estatistica dos Agentes TOP 10
     * @return array
     * @param null
     * @author Franklin Farias
     *
     */
    public function dashTicketByQueue()
    {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('q.id, q.name as queue_name, count(*) as qtd')
            ->from('vw_tickets_encerrados te')
            ->join('queue q', 'te.queue_finish = q.id')
            ->where('DATE(te.finish_time) BETWEEN :dtIni and :dtFim', array(
                ':dtIni' => FksFormatter::StrToDate($this->dtInicial),
                ':dtFim' => FksFormatter::StrToDate($this->dtFinal)))
            ->group('q.id, q.name')
            ->order('q.name')
            ->queryAll();
        return $ret;
    }


/**
 * Retorna as estatísticas gerais padrão do sistema
 * @return array
 */
public function dashTicketStatGeneral()
{
    $ret = Yii::app()->dbCVM->createCommand()
        ->select('*')
        ->from('vw_ticket_stat_general')
        ->order('qtd DESC')
        ->queryAll();
    return $ret;
}



    public function dashGSTEncerrados() {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('COUNT(*) as qtd')
            ->from('vw_tickets_encerrados')
            ->where('queue_finish IN (5,14,15,16,6,21) AND DATE(finish_time) BETWEEN :dtIni and :dtFim', array(
                ':dtIni' => FksFormatter::StrToDate($this->dtInicial),
                ':dtFim' => FksFormatter::StrToDate($this->dtFinal)))
            ->queryAll();
        return $ret[0]['qtd'];
    }

    public function dashGSTTicketsAbertos() {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('COUNT(*) as qtd')
            ->from('ticket')
            ->where('queue_id IN (5,14,15,16) ' .
                'AND ticket_state_id in (select id from ticket_state where type_id in (1,2)) '.
                'AND DATE(create_time) BETWEEN :dtIni and :dtFim', array(
                ':dtIni' => FksFormatter::StrToDate($this->dtInicial),
                ':dtFim' => FksFormatter::StrToDate($this->dtFinal)))
            ->queryAll();
        return $ret[0]['qtd'];
    }

    public function dashGSTTicketsBloqueados() {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('COUNT(*) as qtd')
            ->from('ticket')
            ->where('ticket_lock_id in (1,3) '.
                'AND queue_id IN (5,14,15,16) '.
                'AND DATE(create_time) BETWEEN :dtIni and :dtFim', array(
                ':dtIni' => FksFormatter::StrToDate($this->dtInicial),
                ':dtFim' => FksFormatter::StrToDate($this->dtFinal)))
            ->queryAll();
        return $ret[0]['qtd'];
    }
    public function dashAgentes() {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('COUNT(*) as qtd')
            ->from('users')
            ->where('valid_id = 1')
            ->queryAll();
        return $ret[0]['qtd'];
    }

    public function dashGSTTicketsPendente() {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('COUNT(*) as qtd')
            ->from('ticket')
            ->where('ticket_state_id in (select id from ticket_state where type_id in (4,5)) '.
                'AND queue_id IN (5,14,15,16) '.
                'AND DATE(create_time) BETWEEN :dtIni and :dtFim', array(
                ':dtIni' => FksFormatter::StrToDate($this->dtInicial),
                ':dtFim' => FksFormatter::StrToDate($this->dtFinal)))
            ->queryAll();
        return $ret[0]['qtd'];
    }



/**
 * Retorna todas as perguntas da Pesquisa de Satisfação (Mestre)
 * @return array
 */
public function dashPqsQuestions() {
    $ret = Yii::app()->dbCVM->createCommand()
        ->select('*')
        ->from('vw_survey_questions')
        ->order('position')
        ->queryAll();
    return $ret;
}

    /**
     * Retorna os quantitativos de resposta por pergunta da PQS
     * @param int $idQuestion
     * @return array
     */
    public function dashPqsAnswer($idQuestion) {
        $ret = Yii::app()->dbCVM->createCommand()
            ->select('question_id, answer_id, answer, pos_answer, sum(amount) as amount, sum(amount_answered) as amount_answered, sum(amount_not_answered) as amount_not_answered')
            ->from('vw_survey_answers_new')
            ->where('question_id = :id and (date_vote between :dtIni and :dtFim or date_vote is null)', array(
                ':id' => $idQuestion,
                ':dtIni' => FksFormatter::StrToDate($this->dtInicial),
                ':dtFim' => FksFormatter::StrToDate($this->dtFinal)))
            ->group('question_id, answer_id, answer, pos_answer')
            ->order('pos_answer')
            ->queryAll();
        return $ret;
    }
}
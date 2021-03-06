<?php
/* @var $this DashboardController */
/* @var $form CActiveForm */
/* @var $model DashboardFraport */
$dashPainels = $model->dash01Stats();
$dashAgents = $model->dash02Stats();
$dashQueues = $model->dash03Stats();
$dashForwQueue = $model->dash04ForwardedByQueue();
$dashSLA = $model->dashSLAbyAgents();
$dashStat = $model->dashTicketStatGeneral();
// Ajax
$cmbAgents = $model->dashAllAgents();
// Register Ajax - Change Agents
$cs = Yii::app()->getClientScript();
$cs->registerScript("jsCommon",
    "$('#cmbAgents').change(function () { ".
    "  $('#DashboardFraport_userId').val(this.value); " .
    "  $('#filtro-form').submit(); " .
    "});");
?>

<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto']+$dashPainels[0]['dash01_qtd_fechado'];
                $perc1 = round(($dashPainels[0]['dash01_qtd_aberto'] / $total) * 100,2);
                $perc2 = round(($dashPainels[0]['dash01_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class="count popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash01_qtd_aberto'] . " (" . $perc1;?>%)." data-placement="top" data-trigger="hover"><?php echo $dashPainels[0]['dash01_qtd_aberto'];?></h1>
                <h1 class="count popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash01_qtd_fechado'] . " (" . $perc2;?>%)." data-placement="top" data-trigger="hover"><?php echo $dashPainels[0]['dash01_qtd_fechado'];?></h1>
                <p>Geral</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-tags"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash02_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash02_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count2 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash02_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos na Central Serviços." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash02_qtd_aberto'];?></h1>
                <h1 class=" count2 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash02_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados na Central Serviços." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash02_qtd_fechado'];?></h1>
                <p>Central Serviços</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash03_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash03_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count3 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash03_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos no Suporte Cabeamento." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash03_qtd_aberto'];?></h1>
                <h1 class=" count3 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash03_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados no Suporte Cabeamento." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash03_qtd_fechado'];?></h1>
                <p>Suporte Cabeamento</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash04_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash04_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count4 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash04_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos no N2 - Suporte Técnico Remoto." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash04_qtd_aberto'];?></h1>
                <h1 class=" count4 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash04_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados no N2 - Suporte Técnico Remoto." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash04_qtd_fechado'];?></h1>
                <p>N2 - Suporte Técnico Remoto</p>
            </div>
        </section>
    </div>
</div>
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash05_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash05_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count4 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash05_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos no Suporte Técnico Noturn." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash05_qtd_aberto'];?></h1>
                <h1 class=" count4 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash05_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados no Suporte Técnico Noturn." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash05_qtd_fechado'];?></h1>
                <p>Suporte Técnico Noturno</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash06_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash06_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count4 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash06_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos no Suporte de 3º nível." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash06_qtd_aberto'];?></h1>
                <h1 class=" count4 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash06_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados no Suporte de 3º nível." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash06_qtd_fechado'];?></h1>
                <p>Suporte de 3º nível</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash07_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash07_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count4 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash07_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos no Spam." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash07_qtd_aberto'];?></h1>
                <h1 class=" count4 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash07_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados no Spam." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash07_qtd_fechado'];?></h1>
                <p>Spam</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <?php
                $total = $dashPainels[0]['dash01_qtd_aberto'];
                $perc1 = round(($dashPainels[0]['dash08_qtd_aberto'] / $total) * 100,2);
                $total = $dashPainels[0]['dash01_qtd_fechado'];
                $perc2 = round(($dashPainels[0]['dash08_qtd_fechado'] / $total) * 100,2);
                ?>
                <h1 class=" count4 popovers" data-original-title="Chamados Abertos" data-content="Quantidade de chamados abertos no período: <?php echo $dashPainels[0]['dash08_qtd_aberto'] . ".<br /><b>" . $perc1;?>%</b> dos chamados são abertos no Central de Serviços Fraport." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash08_qtd_aberto'];?></h1>
                <h1 class=" count4 popovers" data-original-title="Chamados Fechados" data-content="Quantidade de chamados encerrados no período: <?php echo $dashPainels[0]['dash08_qtd_fechado'] . ".<br /><b>" . $perc2;?>%</b> dos chamados são fechados no Central de Serviços Fraport." data-placement="top" data-trigger="hover" data-html="true"><?php echo $dashPainels[0]['dash08_qtd_fechado'];?></h1>
                <p>Central de Serviços Fraport</p>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-sm-12">
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Atendimento atendentes</h1>
                    <p>Central de Serviços | Suporte Cabeamento | N2 - Suporte Técnico Remoto | Suporte Técnico Noturno | Suporte de 3º nível | Spam | Central de Serviços Fraport</p>
                </div>
                <div class="task-option">
                    <?php
                    $options = CHtml::listData($cmbAgents,'user_id','full_name');
                    $options[''] = '< Todos >';
                    asort($options);
                    echo CHtml::dropDownList('cmbAgents', $model->userId, $options,
                        array('class'=>'styled hasCustomSelect'));
                    ?>
                </div>
            </div>
            <table id="attendeeAgents" class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Atendente</th>
                    <th>Criados</th>
                    <th>Abertos</th>
                    <th>Pendentes</th>
                    <th>Resolvidos S/ Atendimento</th>
                    <th>Resolvidos</th>
                    <th>Encerrados</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($dashAgents as $value){
                        echo "<tr><td>".$value['user_name'] . "</td>";
                        echo "<td style=\"text-align:center;\">".$value['qtd_criado'] . "</td>";
                        echo "<td style=\"text-align:center;\">".$value['qtd_aberto'] . "</td>";
                        echo "<td style=\"text-align:center;\">".$value['qtd_pendente'] . "</td>";
                        echo "<td style=\"text-align:center;\">".$value['qtd_atendido_ti'] . "</td>";
                        echo "<td style=\"text-align:center;\">".$value['qtd_resolvido'] . "</td>";
                        echo "<td style=\"text-align:center;\">".$value['qtd_encerrado'] . "</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </section>
    </div>

</div>
<div class="row">
    <div class="col-lg-4 col-sm-7">
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Violação de SLA por Atendente</h1>
                    <p>SLA de até 8 horas</p>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Atendente</th>
                    <th>IN</th>
                    <th>SS</th>
                    <th style="text-decoration: overline">IN</th>
                    <th style="text-decoration: overline">SS</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($dashSLA as $value){
                    echo "<tr><td>".$value['user_fullname']."</td>";
                    echo "<td>".$value['qtd_in_filfull']."</td>";
                    echo "<td>".$value['qtd_ss_filfull']."</td>";
                    echo "<td>".$value['qtd_in_violate']."</td>";
                    echo "<td>".$value['qtd_ss_violate']."</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
    <div class="col-lg-4 col-sm-7">
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Encaminhados por Fila</h1>
                    <p>Todas as filas</p>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Fila</th>
                    <th>Qtd</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($dashForwQueue as $value){
                    echo "<tr><td>".$value['queue_name'] . "</td>";
                    echo "<td>".$value['qtd'] . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
    <div class="col-lg-4 col-sm-7">
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Encerrados por Fila</h1>
                    <p>Todas as filas</p>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Fila</th>
                    <th>Qtd</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($dashQueues as $value){
                    echo "<tr><td>".$value['queue_name'] . "</td>";
                    echo "<td>".$value['qtd'] . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Pesquisa de Satisfação</h1>
                    <p>Geral - Todas as filas</p>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-condensed"><tbody>
                    <?php
                    $lst = $model->dashPqsQuestions();
                    foreach ($lst as $value) {
                        // retorna respostas
                        $answers = $model->dashPqsAnswer($value['question_id']);
                        $total = 0;
                        $totalAnswered = 0;
                        $totalNotAnswered = 0;
                        $total = 0;
                        foreach ($answers as $item) {
                            $total += $item['amount'];
                            $totalAnswered += $item['amount_answered'];
                            $totalNotAnswered += $item['amount_not_answered'];
                        }

                        echo "<tr><td><p class=\"text-muted\">".$value['question']."</p></td><td>";

                        if ($value['question_id'] != 10) {
                            // Não é TextArea (Comentário)
                            foreach ($answers as $item) {
                                $perc = ($item['amount'] == 0 ? 0 : round($item['amount'] * 100 / $total, 2));
                                echo $item['answer']." ($perc%)<div class=\"progress progress-sm\">";
                                echo "<div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"$perc\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $perc%\">";
                                echo "<span class=\"sr-only\">$perc% Complete</span>";
                                echo "</div></div>";
                            }
                        } else {
                            // É TextArea (Comentário)
                            $total = $totalAnswered + $totalNotAnswered;
                            $perc = ($item['amount_answered'] == 0 ? 0 : round($item['amount_answered'] * 100 / $total, 2));
                            // Respondido
                            echo "Respondido ($perc%)<div class=\"progress progress-sm\">";
                            echo "<div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"$perc\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $perc%\">";
                            echo "<span class=\"sr-only\">$perc% Complete</span>";
                            echo "</div></div>";

                            $perc = ($item['amount_not_answered'] == 0 ? 0 : round($item['amount_not_answered'] * 100 / $total, 2));
                            // Não respondido
                            echo "Não Respondido ($perc%)<div class=\"progress progress-sm\">";
                            echo "<div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"$perc\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $perc%\">";
                            echo "<span class=\"sr-only\">$perc% Complete</span>";
                            echo "</div></div>";
                        }

                        echo "</td></tr>";
                    }
                    ?>
                    </tbody></table>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>Estatísticas Gerais</h1>
                    <p>Geral</p>
                </div>
            </div>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Atividade</th>
                    <th>Valor Apurado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($dashStat as $value){
                    echo "<tr><td>".$value['title']."</td>";
                    echo "<td>".$value['qtd']."</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
</div>
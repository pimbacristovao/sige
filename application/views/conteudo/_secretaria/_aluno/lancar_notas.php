<div id="content" class="content">
    <div class="row">
        <div class="col-6">
            <h4 class="page-header text-uppercase"><i class="fa fa-list mr-5"></i>LANÇAR NOTAS</h4>
        </div>
        <div class="col-6 text-right">
            <a href="<?= base_url('secretaria/listagem/lancar_notas/'.$notas_disciplina[0]->id_ano.'/'.$notas_disciplina[0]->id_turma.'/'.$notas_disciplina[0]->id_disciplina.'/'.$notas_disciplina[0]->id_classe) ?>"
                class="btn btn-primary">
                <i class="fa fa-arrow-left mr-2"></i>PAGINA ANTERIOR</a>
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive">
        <table class="table table-condensed text-uppercase table-striped">
            <thead>
                <tr>
                    <th class="text-center align-middle" rowspan="4" width="8%">
                        <div id="photo_pfl" class="img-fluid  img-responsive">
                            <img src=" <?= base_url("_assets/upload/".$notas_disciplina[0]->photo); ?>">
                        </div>
                    </th>
                    <th class="text-left" nowrap width="1%">ALUNO: </th>
                    <th class="text-left"><span class="text-danger"><?= $notas_disciplina[0]->nome; ?></span></th>
                </tr>
                <tr class="text-left">
                    <th nowrap>TURMA:</th>
                    <th><span class="text-danger"><?= $notas_disciplina[0]->nome_turma; ?></span></th>
                </tr>
                <tr class="text-left">
                    <th nowrap>ANO LECTIVO:</th>
                    <th><span class="text-danger"><?= $notas_disciplina[0]->ano_let; ?></span></th>
                </tr>
                <tr class="text-left">
                    <th>DISCIPLINA:</th>
                    <th><span class="text-danger"><?= $notas_disciplina[0]->nome_disciplina; ?></span>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    <!------------------------------------------------------------------------------------------------------->
    <?= $this->session->flashdata('msg'); ?>
    <div class="col-12 mx-auto">
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <td>
                        <!--                            1º TRIMESTRE 
                        ------------------------------------------------------------------------- -->
                        <form action="<?= site_url('secretaria/matricula/salvar_nota_1') ?>" method="POST"
                            class="form-horizontal" id="form_notas_1" role="form">
                            <fieldset>
                                <legend class="text-secondary">
                                    <h4>1º TRIMESTRE</h4>
                                </legend>
                                <!---------------- campos ocultos ------------------>
                                <input type="hidden" name="id_notas_disciplina"
                                    value="<?= $notas_disciplina[0]->id_notas_disciplina; ?>" />
                                <input type="hidden" name="anolectivo_id"
                                    value="<?= $notas_disciplina[0]->anolectivo_id; ?>" />
                                <input type="hidden" name="turma_id" value="<?= $notas_disciplina[0]->turma_id; ?>" />
                                <input type="hidden" name="disciplina_id"
                                    value="<?= $notas_disciplina[0]->disciplina_id; ?>" />
                                <input type="hidden" name="classe_id" value="<?= $notas_disciplina[0]->id_classe; ?>" />
                                <!---------------- fim campos ocultos ------------------>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="mac_1" class="col-md-1 control-label text-right">MAC</label>
                                            <div class="col-md-2">
                                                <input type="number" name="mac_1" id="mac_1"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->mac_1;?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="cpp_1" class="col-md-1 control-label text-right">CPP</label>
                                            <div class="col-md-2">
                                                <input type="number" name="cpp_1" id="cpp_1"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->cpp_1; ?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <div class="col-md-2 ml-5">
                                                <button type="submit" class="btn btn-primary m-r-5">
                                                    <i class="fa fa-save mr-2"></i>SALVAR
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </td>
                </tr>
                <!-- ======================================================================================================== -->
                <tr>
                    <td>
                        <!--                        2º TRIMESTRE 
                        ------------------------------------------------------------------------- -->
                        <form action="<?= site_url('secretaria/matricula/salvar_nota_2') ?>" method="POST"
                            class="form-horizontal" id="form_notas_2" role="form">
                            <fieldset>
                                <legend class="text-secondary">
                                    <h4>2º TRIMESTRE</h4>
                                </legend>
                                <!---------------- campos ocultos ------------------>
                                <input type="hidden" name="id_notas_disciplina"
                                    value="<?= $notas_disciplina[0]->id_notas_disciplina; ?>" />
                                <input type="hidden" name="anolectivo_id"
                                    value="<?= $notas_disciplina[0]->anolectivo_id; ?>" />
                                <input type="hidden" name="turma_id" value="<?= $notas_disciplina[0]->turma_id; ?>" />
                                <input type="hidden" name="disciplina_id"
                                    value="<?= $notas_disciplina[0]->disciplina_id; ?>" />
                                <input type="hidden" name="classe_id" value="<?= $notas_disciplina[0]->id_classe; ?>" />
                                <!---------------- fim campos ocultos ---------------- -->
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="mac_2" class="col-md-1 control-label text-right">MAC</label>
                                            <div class="col-md-2">
                                                <input type="number" name="mac_2" id="mac_2"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->mac_2;?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="cpp_2" class="col-md-1 control-label text-right">CPP</label>
                                            <div class="col-md-2">
                                                <input type="number" name="cpp_2" id="cpp_2"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->cpp_2; ?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <div class="col-md-2 ml-5">
                                                <button type="submit" class="btn btn-primary m-r-5">
                                                    <i class="fa fa-save mr-2"></i>SALVAR
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </td>
                </tr>
                <!-- ======================================================================================================== -->
                <tr>
                    <td>
                        <!--                            3º TRIMESTRE 
                        ------------------------------------------------------------------------- -->
                        <form action="<?= site_url('secretaria/matricula/salvar_nota_3') ?>" method="POST"
                            class="form-horizontal" id="form_notas_3" role="form">
                            <fieldset>
                                <legend class="text-secondary">
                                    <h4>3º TRIMESTRE</h4>
                                </legend>
                                <!---------------- campos ocultos ------------------>
                                <input type="hidden" name="id_notas_disciplina"
                                    value="<?= $notas_disciplina[0]->id_notas_disciplina; ?>" />
                                <input type="hidden" name="anolectivo_id"
                                    value="<?= $notas_disciplina[0]->anolectivo_id; ?>" />
                                <input type="hidden" name="turma_id" value="<?= $notas_disciplina[0]->turma_id; ?>" />
                                <input type="hidden" name="disciplina_id"
                                    value="<?= $notas_disciplina[0]->disciplina_id; ?>" />
                                <input type="hidden" name="classe_id" value="<?= $notas_disciplina[0]->id_classe; ?>" />
                                <!---------------- fim campos ocultos ------------------>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="mac_3" class="col-md-1 control-label text-right">MAC</label>
                                            <div class="col-md-2">
                                                <input type="number" name="mac_3" id="mac_3"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->mac_3;?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="cpp_3" class="col-md-1 control-label text-right">CPP</label>
                                            <div class="col-md-2">
                                                <input type="number" name="cpp_3" id="cpp_3"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->cpp_3; ?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <label for="ce" class="col-md-1 control-label text-right">CE</label>
                                            <div class="col-md-2">
                                                <input type="number" name="ce" id="ce"
                                                    class="form-control border-primary"
                                                    value="<?= $notas_disciplina[0]->ce; ?>" placeholder="00.0"
                                                    autocomplete="off"
													min="0"
													max="10">
                                            </div>
                                            <!-- --------------------------------------------------------------- -->
                                            <div class="col-md-2 ml-5">
                                                <button type="submit" class="btn btn-primary m-r-5">
                                                    <i class="fa fa-save mr-2"></i>SALVAR
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
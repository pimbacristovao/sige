<!-- INICIO CONTEUDO -->
<div id="content" class="content">
    <h5 class="page-header"><i class="fa fa-user mr-5"></i>PERFIL DO FUNCIONÁRIO</h5>
    <?= $this->session->flashdata('msg'); ?>
    <!-- begin invoice -->
    <div class="mt-5">

        <!-- INICIO DADOS DO ALUNO -->
        <div class="tab-pane " id="profile-about">
            <!-- begin table -->
            <div class="table-responsive">
                <table class="table table-striped align-middle text-uppercase"> <!--titulo-tabela  -->
                    <tbody>
                        <tr class="highlight">
                            <td class="text-center align-middle" width="10%" rowspan="5">
                                <!-- ----------------------------------------- -->
                                <div id="photo_pfl" class="img-fluid img-thumbnail img-responsive">
                                    <img src=" <?= base_url("_assets/upload/".$funcionario['photo']); ?>">
                                </div>
                            </td>
                            <td class="text-right" width="15%"><strong>Nome:</strong></td>
                            <td class="text-left" width="35%">
                                <strong><?=$funcionario['nome_funcionario']?></strong></td>
                            <td class="text-right" width="20%"><strong>Data de Nascimento:</strong></td>
                            <td class="text-left" width="30%">
                                <strong><?= date('d/ m/ Y', strtotime($funcionario['nascimento_funcionario'])); ?></strong>
                            </td>
                        </tr>
                        <tr class="highlight">
                            <td class="text-right"><strong>Género:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['genero_funcionario']?></strong></td>
                            <td class="text-right"><strong>Nº B.I:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['bi_funcionario']?></strong></td>
                        </tr>
                        <tr class="highlight">
                            <td class="text-right"><strong>Morada:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['endereco_funcionario']?></strong></td>
                            <td class="text-right"><strong>Telemóvel:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['telemovel_funcionario']?></strong></td>
                        </tr>
                        <tr class="highlight">
                            <td class="text-right"><strong>E-Mail:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['email_funcionario']?></strong></td>
                            <td class="text-right"><strong>Nome de Utilizador:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['nome_user']?></strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Função:</strong></td>
                            <td class="text-left"><strong><?php 
                                if ($funcionario['nivel_acesso'] == "1") {
                                    echo 'Director(a)';
                                } elseif ($funcionario['nivel_acesso'] == "2") {
                                    echo 'Técnico de Administrativo';
                                } elseif ($funcionario['nivel_acesso'] == "3") {
                                    echo 'Técnico de Recursos Humanos';
                                } elseif ($funcionario['nivel_acesso'] == "4") {
                                    echo 'Coordenador(a)';
                                } elseif ($funcionario['nivel_acesso'] == "5") {
                                    echo 'Professor(a)';
                                } elseif ($funcionario['nivel_acesso'] == "6") {
                                    echo 'Técnico de Informática';
                                } elseif ($funcionario['nivel_acesso'] == "7") {
                                    echo 'Auxiliar de Serviços Gerais';
                                } elseif ($funcionario['nivel_acesso'] == "8") {
                                    echo 'Seguraça';
                                }
                            ?></strong></td>
                            <td class="text-right"><strong>Nº de Funcionário:</strong></td>
                            <td class="text-left"><strong><?=$funcionario['id_funcionario']?></strong></td>
                        </tr>
                    </tbody>
                    <tfoot>
					<tr>
						<th colspan="5">
							<span class="pull-left">
								<!-- begin dropdown -->
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-dark"><i class="fa fa-edit mr-2"></i>
									ALTERAR INFORMAÇÕES</a>
									<a href="#" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown"></a>
									<ul class="dropdown-menu pull-none">
										<!------------------------------------------------------------------------------------------>
										<li>
											<a href="<?= site_url('rh/funcionario/editar/' . $funcionario['id_funcionario']); ?>">
											<i class="fa fa-edit mr-2"></i>EDITAR FUNCIONÁRIO
											</a>
										</li>
										<!------------------------------------------------------------------------------------------>
										<li>
											<a href="<?= site_url('rh/funcionario/carregar_imagem?id_funcionario=' . $funcionario['id_funcionario']) ?>">
											<i class="fa fa-camera mr-2"></i>ALTERAR FOTOGRAFIA</a>
										</li>
										<!------------------------------------------------------------------------------------------>
										<!-- <li><a href="#modal-utilizador" data-toggle="modal">
												<i class="fa fa-user-plus t-plus-1 fa-fw fa-lg mr-2"></i>CRIAR UTILIZADOR
											</a>
										</li> -->
									</ul>
								</div>
								<!-- end dropdown -->
								<!------------------------------------------------------------------------------------------>
								<a href="<?= site_url('rh/funcionario/apagar/' . $funcionario['id_funcionario']) ?>"
										class="btn btn-sm btn-outline-danger ml-2">
											<i class="fa fa-trash mr-2"></i>EXCLUIR FUNCIONÁRIO
									</a>
							</span>
							<!---------------------------------------------------------------------------->
							</th>
						</tr>
                    </tfoot>
                </table>
            </div><!-- end table -->
        </div><!-- end tab-pane -->
    </div><!-- end container -->
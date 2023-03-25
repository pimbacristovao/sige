<!--		INICIO CONTEUDO		-->
<div id="content" class="content">
	<!---------------------------------------------------------------------------------------->
	<!-- TITULO CONTEUDO -->
	<h5 class="page-header text-center"><i class="fa fa-user mr-2"></i>CRIAR UTILIZADOR</h5>
	<?= $this->session->flashdata('msg'); ?>

	<div class="">

		<form action="<?= site_url('rh/funcionario/add_utilizador') ?>" method="POST" id="form_utilizador">
			<div class="modal-body">
				<!-- ======================= CAMPOS OCULTOS ======================= -->
				<input type="hidden" name="id_funcionario" value="<?= $funcionario['id_funcionario'] ?>" />
				<!--------------------------------------------------------------------------->
				<div class="col-sm-6 mx-auto">
					<!--    INPUT NOME DE UTILIZADOR   -->
					<div class="form-group col-12 my-3">
						<label>Nome de utilizador</label>
						<input type="text" name="nome_user" id="nome_user" class="form-control border-primary text-primary" placeholder="Ex. Ermano Cristovão" autocomplete="off" />
						<!-- <?= form_error('nome_user')?> -->
					</div>
					<!--    INPUT PASSWORD   -->
					<div class="form-group col-12 my-3">
						<label>Password</label>
						<input type="password" name="password" id="password" class="form-control border-primary text-primary" placeholder="Digite a palavra passe" />
					</div>
					<!--    INPUT CONFIRMAR PASSWORD   -->
					<div class="form-group col-12 my-3">
						<label>Confirme a password</label>
						<input type="password" name="confirm_password" id="confirm_password" class="form-control border-primary text-primary" placeholder="Confirme a palavra passe" />
					</div>
				</div>
				<!--------------------------------------------------------------------------->
			</div> <!-- FIM MODAL BODY -->
			<!-- <div class="modal-footer"> -->
				<!-- TODO: redirecionar para uma pagina caso seja cancelado a inserção do user no sistema -->
				<!-- <a href="#" class="btn btn-danger " data-dismiss="modal">
					<i class="fa fa-arrow-left mr-2"></i>Voltar</a> -->
				
				
			<!-- </div> -->
			<div class="d-flex justify-content-center">
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save mr-2"></i>Guardar</button>
			</div>
		</form><!-- FIM MODAL FORM -->

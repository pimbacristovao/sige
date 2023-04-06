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
						<input type="text" name="nome_user" id="nome_user" class="form-control border-primary text-primary" onkeydown="return (event.keyCode !== 32);" onInput="verificar_nome_utilizador()" placeholder="Ex. aldaircristovao" autocomplete="off"  required />
						<span id="check-username" class="mt-4 mr-4"></span> <!-- tag responsável por apresentar a mensagem ao utilizador -->
					</div>
					<!--    INPUT PASSWORD   -->
					<div class="form-group col-12 my-3">
						<label>Password</label>
						<input type="password" name="password" id="password" class="form-control border-primary text-primary" placeholder="Digite a palavra passe" required />
					</div>
					<!--    INPUT CONFIRMAR PASSWORD   -->
					<div class="form-group col-12 my-3">
						<label>Confirme a password</label>
						<input type="password" name="confirm_password" id="confirm_password" class="form-control border-primary text-primary" placeholder="Confirme a palavra passe" required />
					</div>
				</div>
				<!--------------------------------------------------------------------------->
			</div> <!-- FIM MODAL BODY -->
			<div class="d-flex justify-content-center">
				<button type="submit" id="submit" class="btn btn-primary px-3">Criar utilizador</button>
			</div>
		</form><!-- FIM FORM -->

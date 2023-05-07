<!--		INICIO CONTEUDO		-->
<div id="content" class="content ">
	<!---------------------------------------------------------------------------------------->
	<!-- <?= $this->session->flashdata('msg'); ?> -->

	<div>
		<div class="col-sm-12 mx-auto contentor">
			<div class="conteudo col-sm-12 mx-auto">
				<form action="<?= site_url('') ?>" method="POST" id="form_recuperar_password">
					<div>
						<!--------------------------------------------------------------------------->
						<div class="col-sm-6 mx-auto">
							<!--    INPUT E-MAIL DE RECUPERAÇÃO DE PALAVRA-PASSE   -->
							<div class="form-group col-12 my-3">
								<input type="email" name="email_recuperacao_user" id="email_recuperacao_user" class="form-control border-primary text-primary" placeholder="nome@exemplo.com" autocomplete="off" />
							</div>
						</div>
						<!--------------------------------------------------------------------------->
						<div class="d-flex justify-content-center">
							<button type="submit" class="btn btn-primary btn-lg">
								<i class=""></i>Recuperar</button>
						</div>
					</div> <!-- end div -->
				</form> <!-- fim form -->
			</div>
		</div>

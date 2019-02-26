<div class="container">
    <form class="form-horizontal" action="gestionnaires.php?do=Insert" method="post">
    <!-- start nom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="nom" class="form-control"required="required"/>
            </div>
        </div>
    <!-- End nom -->
    <!-- start prenom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Prenom</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="prenom" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End prenom -->
     <!-- start email -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">email</label>
            <div class="col-sm-10 col-md-4">
                <input type="email" name="email" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End email -->
    <!-- start token -->
<!--
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Token</label>
            <div class="col-sm-10 col-md-4">
-->             <?php $token = uniqid(rand(), true); ?>
                <input type="hidden" name="token" class="form-control" value="<?= $token ?>"/>
<!--
            </div>
        </div>
-->
    <!-- End token -->
 
    <!-- envoyer -->
          <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Ajouter" class="btn btn-primary"/>
            </div>    
        </div>
        <input type="hidden" name="button_pressed" value="1" />
    </form>

</div>

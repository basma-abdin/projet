<div class="container">
    <form class="form-horizontal" action="members.php?do=Insert" method="post">
    <!-- start login -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Login</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="login" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End login -->
    <!-- start nom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="nom" class="form-control"required="required"/>
            </div>
        </div>
    <!-- End nom -->
    <!-- start prenom -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Prenom</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="prenom" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End prenom -->
    <!-- start mdp -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Mot de Pass</label>
            <div class="col-sm-10 col-md-6">
                <input type="password" name="mdp" class="form-control" required="required"/>
            </div>
        </div>
    <!-- End mdp -->
    <!-- start role -->
         <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Role</label>
            <div class="col-sm-10 col-md-6">
               <select name="role">
                <option value="user">user</option>
                <option value="admin">admin</option>
                </select>   
            </div>
        </div>
    <!-- End role -->
    <!-- start actif -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Actif</label>
            <div class="col-sm-10 col-md-6">
               <select name="actif">
                <option value="0">No</option>
                <option value="1">Oui</option>
                </select>   
            </div>
        </div>
    <!-- End actif -->
    <!-- envoyer -->
          <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Ajouter" class="btn btn-primary"/>
            </div>    
        </div>

    </form>

</div>

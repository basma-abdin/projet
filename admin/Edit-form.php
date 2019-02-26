<h1 class="text-center">Modifier votre mdp et/ou actif</h1>
<div class="container">
    <form class="form-horizontal" action="members.php?do=Update" method="post">
        <input type="hidden" name="uid" value="<?= $Uid ?>" />
        <!--- mdp --->
        <div class="form-group">
            <label class="col-sm-2 control-label">Mot de pass</label>
            <div class="col-sm-2 col-md-4">
            <input type="password" name="password" placeholder="si vide,recuper l'ancien valeur" class="form-control"/>
                <input type="hidden" name="oldpassword" value="<?= $row['mdp'] ?>" class="form-control"/>
            </div>    
        </div>
      <!--- actif -->
        <div class="form-group">
            <label class="col-sm-2 control-label">actif</label>
            <div class="col-sm-2 col-md-4">
                <select name="actif-choix">
                <option value="Non">choisi</option>
                <option value="0">non actif</option>
                <option value="1">actif</option>
                </select>      
                <input type="hidden" name="oldactif" value="<?= $row['actif'] ?>" class="form-control"/>
            </div>    
        </div>
        <!-- envyer -->
          <div class="form-group">
            <div class="col-sm-10">
            <input type="submit" 
                value="Edit" class="btn btn-primary"/>
            </div>    
        </div>
        
        
        
        
        
    </form>
</div>
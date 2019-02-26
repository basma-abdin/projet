 <?php require("../db_config.php"); ?>
<div class="container">
    <h3>Notice: cliquer pour modifier</h3>
 <form class="form-horizontal" action="soutenances.php?do=Update" method="post">  
       <input type="hidden" name="stid" value="<?= $stid ?>" />
        <?php
        $sql="SELECT * FROM soutenances WHERE stid= ?";
        $res=$db->prepare($sql);
        $res->execute(array($stid));
        $old=$res->fetch();
         $oldsid= $old['sid']; $oldtut1=$old['tuteur1'];
         $oldtut2=$old['tuteur2'];$olddate=$old['date'];
              $oldsalle=$old['salle'];
     ?>
     <!--- start stageid---->
  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Stage id </label>
     <div class=" col-sm-4">
       <select name="sid">
           <?php
            $sql="SELECT sid FROM stages where sid <> ?";
            $res=$db->prepare($sql);
            $res->execute(array($oldsid));
            $rows=$res->fetchALL();
    ?>    <option value="<?= $oldsid ?>"><?= $oldsid ?></option> <?php
            foreach($rows as $row) {
           ?>
         <option value="<?= $row['sid'] ?>"><?= $row['sid'] ?></option>
           <?php } ?>
            </select>   
            </div>
        </div>   
    <!--- End stageid---->   
          <!--- start tut1--->
  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Tuteur 1 </label>
     <div class=" col-sm-4">
       <select name="tut1">
           <?php
            $sql="SELECT uid FROM users WHERE uid <> ?";
            $res=$db->prepare($sql);
            $res->execute(array($oldtut1));
            $rows=$res->fetchALL();
    ?>    <option value="<?= $oldtut1 ?>"><?= $oldtut1 ?></option> <?php
            foreach($rows as $row) {
           ?>
         <option value="<?= $row['uid'] ?>"><?= $row['uid'] ?></option>
           <?php } ?>
            </select>   
            </div>
        </div>   
    <!--- End tut1---->   
  <!--- start tut2--->
  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Tuteur 2 </label>
     <div class=" col-sm-4">
       <select name="tut2">
           <?php
            $sql="SELECT uid FROM users WHERE uid <> ? ";
            $res=$db->prepare($sql);
            $res->execute(array($oldtut2));
            $rows=$res->fetchALL();
      ?>    <option value="<?= $oldtut2 ?>"><?= $oldtut2 ?></option> <?php
            foreach($rows as $row) {
           ?>
         <option value="<?= $row['uid'] ?>"><?= $row['uid'] ?></option>
           <?php } ?>
            </select>   
            </div>
        </div>   
    <!--- End tut2----> 
     <!--- Start date----> 
   <div class="form-group form-group-lg">
      <label class="col-sm-2 control-label">Date</label>
          <div class="col-sm-10 col-md-4">
            <input type="datetime-local" name="date" class="form-control" placeholder="<?= $olddate ?>"/>
              <input type="hidden" name="olddate" class="form-control" value="<?= $olddate ?>" />
        </div>
    </div> 
     <!--- End date----> 
     <!--- Start salle----> 
      <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Salle</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="salle" class="form-control" placeholder="<?= $oldsalle ?>" />
                  <input type="hidden" name="oldsalle" class="form-control" value="<?= $oldsalle ?>" />
            </div>
        </div>
         <!--- End salle----> 
 
       <!-- envoyer -->
          <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Modifier" class="btn btn-primary"/>
            </div>    
        </div>  
      
         
         
</form>
 
</div>
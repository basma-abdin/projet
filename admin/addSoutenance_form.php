 <?php require("../db_config.php"); ?>
<div class="container">
 <form class="form-horizontal" action="soutenances.php?do=Insert" method="post">  
     <!--- start stageid---->
  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Stage id </label>
     <div class=" col-sm-4">
       <select name="sid">
           <?php
            $sql="SELECT sid FROM stages
WHERE stages.sid <> ALL(SELECT sid FROM soutenances )";
            $res=$db->prepare($sql);
            $res->execute();
            $rows=$res->fetchALL();
    ?>    <option value="">choisir..</option> <?php
            foreach($rows as $row) {
           ?>
         <option value="<?= $row['sid'] ?>"><?= $row['sid'] ?></option>
           <?php } ?>
            </select>   
            </div>
        </div>  
     <!---  SELECT sid FROM stages
WHERE stages.sid <> ALL(SELECT sid FROM soutenances ) -->
    <!--- End stageid---->   
          <!--- start tut1--->
  <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Tuteur 1 </label>
     <div class=" col-sm-4">
       <select name="tut1">
           <?php
            $sql="SELECT uid FROM users WHERE role=?";
            $res=$db->prepare($sql);
            $res->execute(array('user'));
            $rows=$res->fetchALL();
    ?>    <option value="">choisir..</option> <?php
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
            $sql="SELECT uid FROM users WHERE role=?";
            $res=$db->prepare($sql);
            $res->execute(array('user'));
            $rows=$res->fetchALL();
    ?>    <option value="">choisir..</option> <?php
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
            <input type="datetime-local" name="date" class="form-control" required="required" />
        </div>
    </div> 
     <!--- End date----> 
     <!--- Start salle----> 
      <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Salle</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="salle" class="form-control" required="required"/>
            </div>
        </div>
         <!--- End salle----> 
 
       <!-- envoyer -->
          <div class="form-group">
            <div class="col-sm-10 col-md-6">
            <input type="submit" 
                value="Ajouter" class="btn btn-primary"/>
            </div>    
        </div>  
      
         
         
</form>
 
</div>
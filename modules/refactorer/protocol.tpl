
<form method="post" action="index.php?serv=Refactorer:refactoring" >

  <div>
    <label>Search</label>
    <textarea name="search" style="width:500px;height:200px;" ><?php echo $this->vars->search; ?></textarea>
  </div>
  
  <div>
    <label>Replace</label>
    <textarea name="replace" style="width:500px;height:200px;" ><?php echo $this->vars->replace; ?></textarea>
  </div>
  
  <div>
    <label>Path</label>
    <input type="text" style="width:250px;" name="path" value="<?php echo $this->vars->path; ?>" />
  </div>
  
  <div>
    <label>Ending</label>
    <input type="text" style="width:250px;" name="ending" value="<?php echo $this->vars->ending; ?>" />
  </div>
  
  <div>
    <input type="submit" value="refactor" />
  </div>

</form>


<label>Files</label>
<?php echo $this->vars->files; ?>
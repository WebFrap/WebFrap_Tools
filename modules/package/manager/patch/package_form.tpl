
<form 
	method="post"
	action="index.php?serv=PackageManager-Patch:buildPackage" >

  <fieldset>
    <legend>Patch Data</legend>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Deploy Path:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="deploy_path" style="width:250px;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Repo Root:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="repo_root" style="width:250px;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Patch Name:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="patch_name" style="width:250px;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Patch Path:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="patch_path" style="width:250px;display:table-cell;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="display:table-cell;vertical-align:top;width:120px;" >Files:</label>
      <textarea name="file_list" style="display:table-cell;width:500px;height:200px;"  ></textarea>
    </div>

    <div>
      <input type="submit" value="Build Patch" />
    </div>
    
  </fieldset>

</form>






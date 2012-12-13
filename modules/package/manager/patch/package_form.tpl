
<?php if( $this->vars->message ){ 
  
  echo "<h2>Response</h2>";
  echo "<pre style=\"max-height:300px;overflow:auto;\" >{$this->vars->message}</pre>";
  
} ?>

<form 
	method="post"
	action="index.php?serv=PackageManager-Patch:buildByJson" >

  <fieldset>
    <legend>By Json</legend>

    <div style="display:table-row;" >
      <label style="display:table-cell;vertical-align:top;width:120px;" >Json Raw:</label>
      <textarea name="json_raw" style="display:table-cell;width:700px;height:250px;"  ></textarea>
    </div>
    
    <div style="display:table-row;" >
      <label style="display:table-cell;vertical-align:top;width:120px;" >No Data:</label>
      <div style="display:table-cell;width:700px;" >
      	<input type="checkbox" name="no_data"  />
      </div>
    </div>

    <div>
      <input type="submit" value="Build Patch" />
    </div>
    
  </fieldset>

</form>


<form 
	method="post"
	action="index.php?serv=PackageManager-Patch:buildByForm" >

  <fieldset>
    <legend>By Form</legend>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Deploy Path:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="deploy_path" style="width:350px;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Repo Root:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="repo_root" style="width:350px;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Patch Name:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="patch_name" style="width:350px;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="table-cell;width:120px;" >Patch Path:</label>
      <div style="display:table-cell;" >
      	<input type="text" name="patch_path" style="width:350px;display:table-cell;"  />
      </div>
    </div>
    
    <div style="display:table-row;" >
      <label style="display:table-cell;vertical-align:top;width:120px;" >Files:</label>
      <textarea name="file_list" style="display:table-cell;width:700px;height:250px;"  ></textarea>
    </div>

    <div>
      <input type="submit" value="Build Patch" />
    </div>
    
  </fieldset>

</form>



<form method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>">
<input type="text" name="product_id">
<select name="category">
<option value="ovenmitt">Pot Holder</option>
<option value="fryingpan">Frying Pan</option>
<option value="torch">Kitchen Torch</option>
</select>
<input type="submit" name="submit">
</form>
Here are the submitted values:

product_id: 
<?php if(isset($_POST['product_id'])) print $_POST['product_id']; ?>
<br/>
category: 
<?php if(isset($_POST['category'])) print $_POST['category']; ?>
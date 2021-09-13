

<section id="admin">
		<div class="container">	
			<div class="row">

				<div class="col-sm-12">
				<h3>Edit products</h3>
					<form id="operations"> 
						<input type="button" name="insert" value="INSERT"/> 
						<input type="button" name="update" value="UPDATE"/> 
						<input type="button" name="delete" value="DELETE"/> 
					</form>
				</div>

				<div class="col-sm-8" id="updateFormDiv">
				<h3>Update form</h3>
					<form id="updateForm" action="models/books/updateBook.php" method="POST"> 
						
						
					</form>
				</div>

				<div class="col-sm-8" id="insertFormDiv">
				<h3>Insert form</h3>
					<form id="insertForm" action="models/books/insertBook.php" method="POST"> 
						<label>Name:</label><input type="text" name="name" />
						<label>Author:</label><input type="text" name="author" />
						<label>Price:</label><input type="number" name="price"/><br/>

						<label>In Stock:</label> <input type="number" name="stock"/>
						<label>Featured:</label><input type="checkbox" name="featured" id="featured"><br/>
					
						<label>Details:</label>
						<textarea name="text" rows=6 cols=10></textarea>
						<input type="button" id="submitInsert" name="submitInsert" value="Save"/>
						
					</form>
				</div>

				<div class="col-sm-4" id="errorsDiv">
					
				</div>

				<div class="col-sm-12">
					<div id="adminProducts">

					</div>
				</div>

				<div class="col-sm-12">

					<h3>Pages visited in last 24 hours</h3>
					<table id="logData">
						
						
					</table>
					<input name="excel" type="button" value="Export to excel"/>
				</div>

				<div class="col-sm-12">
					<h3>Currently logged in users</h3>
					<table id="userData">
						
						
					</table>
					
				</div>
				
			</div>
		</div>
</section>


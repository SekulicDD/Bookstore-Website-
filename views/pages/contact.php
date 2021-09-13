<div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center">Contact <strong>Us</strong></h2>    			    				    									
				</div>			 		
			</div>    	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Get In Touch</h2>
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<form id="main-contact-form" class="contact-form row" name="contact-form" action="models/users/sendMessage.php" method="post" onSubmit="return regex()">
				            <div class="form-group col-md-6">
				                <input type="text" id="name" name="name" class="form-control" required="required" placeholder="Name">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" id="email" name="email" class="form-control" required="required" placeholder="Email">
				            </div>
				            <div class="form-group col-md-12">
				                <input type="text"id="subject" name="subject" class="form-control" required="required" placeholder="Subject">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="message" id="mess" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
				            </div>                        
				            <div class="form-group col-md-12">
				                <input id="send" type="submit" class="btn btn-primary pull-right" name="send" value="Submit">
				            </div>
                            <div class="form-group col-md-12" id="errors">
                    
                            </div>
				        </form>
                        
	    			</div>
                   
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Contact Info</h2>
	    				<address>
	    					<p>Book Store</p>
							<p>Zdravka Čelara 16, Beograd</p>
							<p>Beograd</p>
							<p>Mobile: +2346 17 38 93</p>
							<p>Email: bookstore@company.com</p>
	    				</address>
	    				<div class="social-networks">
	    					<h2 class="title text-center">Social Networking</h2>
							<ul>
								<li>
									<a href="www.facebook.com"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="www.twitter.com"><i class="fa fa-twitter"></i></a>
								</li>												
							</ul>
	    				</div>
	    			</div>
    			</div>    			
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->
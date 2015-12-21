<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>BOOTSTRAP CHAT EXAMPLE</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="http://lukisongroup.int/widget/bootstrap-chat/assets/css/bootstrap.css" rel="stylesheet" />

</head>
<body style="font-family:Verdana">
  <div class="container">
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                RECENT CHAT HISTORY
            </div>
            <div class="pre-scrollableChatBase panel-body">
				<ul class="media-list">
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle " src="http://lukisongroup.int/upload/hrd/orgimage/piter.png" />
								</a>
								<div class="media-body" >
									Donec sit amet ligula enim. Duis vel condimentum massa.              
									Donec sit amet ligula enim. Duis vel condimentum massa.Donec sit amet ligula enim. 
									Duis vel condimentum massa.
									Donec sit amet ligula enim. Duis vel condimentum massa.
									<br />
								   <small class="text-muted">Alex Deo | 23rd June at 5:00pm</small>
									<hr />
								</div>
							</div>

						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle " src="http://lukisongroup.int/upload/hrd/orgimage/ailey.png" />
								</a>
								<div class="media-body" >
									Donec sit amet ligula enim. Duis vel condimentum massa.              
									Donec sit amet ligula enim. Duis vel condimentum massa.Donec sit amet ligula enim. 
									Duis vel condimentum massa.
									Donec sit amet ligula enim. Duis vel condimentum massa.
									<br />
								   <small class="text-muted">Jhon Rexa | 23rd June at 5:00pm</small>
									<hr />
								</div>
							</div>

						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle " src="http://lukisongroup.int/upload/hrd/orgimage/stephen.png"/>
								</a>
								<div class="media-body" >
									Donec sit amet ligula enim. Duis vel condimentum massa.              
									Donec sit amet ligula enim. Duis vel condimentum massa.Donec sit amet ligula enim. 
									Duis vel condimentum massa.
									Donec sit amet ligula enim. Duis vel condimentum massa.
									<br />
								   <small class="text-muted">Alex Deo | 23rd June at 5:00pm</small>
									<hr />
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle " src="http://lukisongroup.int/upload/hrd/orgimage/tano.png" />
								</a>
								<div class="media-body" >
									Donec sit amet ligula enim. Duis vel condimentum massa.              
									Donec sit amet ligula enim. Duis vel condimentum massa.Donec sit amet ligula enim. 
									Duis vel condimentum massa.
									Donec sit amet ligula enim. Duis vel condimentum massa.
									<br />
								   <small class="text-muted">Jhon Rexa | 23rd June at 5:00pm</small>
									<hr />
								</div>
							</div>

						</div>
					</li>
				</ul>
            </div>
            <div class="panel-footer">
                <div class="input-group">
					<input type="text" class="form-control" style="height:100px" placeholder="Enter Message" />
					<span class="input-group-btn">
						<button class="btn btn-info" style="height:100px" type="button">SEND</button>
					</span>
				</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
               ROOMS		
			</div>
			<div class="pre-scrollableRooms	 panel-body" id="room">
				<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/piter.png" />
								</a>
								<div class="media-body" >
									<h5>Alex Deo | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/ailey.png" />
								</a>
								<div class="media-body" >
									<h5>Jhon Rexa | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/stephen.png" />
								</a>
								<div class="media-body" >
									<h5>Alex Deo | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
			</div>
			<div class="panel-heading">
               ONLINE USERS		
			</div>
			<div class="pre-scrollableUser panel-body" id="user">
				<ul class="media-list">
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/piter.png" />
								</a>
								<div class="media-body" >
									<h5>Alex Deo | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/ailey.png" />
								</a>
								<div class="media-body" >
									<h5>Jhon Rexa | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/stephen.png" />
								</a>
								<div class="media-body" >
									<h5>Alex Deo | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="http://lukisongroup.int/upload/hrd/orgimage/tano.png" />
								</a>
								<div class="media-body" >
									<h5>Jhon Rexa | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="assets/img/user.png" />
								</a>
								<div class="media-body" >
									<h5>Alex Deo | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="assets/img/user.gif" />
								</a>
								<div class="media-body" >
									<h5>Jhon Rexa | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="assets/img/user.png" />
								</a>
								<div class="media-body" >
									<h5>Alex Deo | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media">
								<a class="pull-left" href="#">
									<img class="media-object img-circle" style="max-height:40px;" src="assets/img/user.gif" />
								</a>
								<div class="media-body" >
									<h5>Jhon Rexa | User </h5>                                                    
								   <small class="text-muted">Active From 3 hours</small>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>        
    </div>
</div>
  </div>
</body>
</html>

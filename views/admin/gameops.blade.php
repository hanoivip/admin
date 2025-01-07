@extends('hanoivip::admin.layouts.admin')

@section('title', 'Game Operation')

@section('content')
<section class="content-header">
  <h4>
    Game Operation Center
  </h4>
</section>
 <section class="content">
    <div class="row">
      	<div>
      		<div class="box box-primary">
      			<div class="box-header with-border">
      				
				</div>
	            <div class="box-header with-border">
	              <h3 class="box-title">Game Data Control</h3>
	            </div>
	            
	            <form role="form" method="GET" action="{{ route('ecmin.gameops.update') }}">
	              <div class="box-footer">
	                <button type="submit" class="btn btn-primary">Update SVN</button>
	              </div>
	            </form>
	            
	            <form role="form" method="POST" action="{{ route('ecmin.gameops.init') }}">
	            	{{ csrf_field() }}
	              <div class="box-body">
	                <div class="form-group">
	                  <select id="svname" name="svname" style="width: 100%;">
                		{{ show_user_servers() }}
            		</select>
            		<button type="submit" class="btn btn-primary">Init Server</button>
	                </div>
	              </div>
	              <div class="box-footer">
	                
	              </div>
	            </form>
	            
	            <form role="form" method="POST" action="{{ route('ecmin.gameops.apply') }}">
	            	{{ csrf_field() }}
	              <div class="box-body">
	                <div class="form-group">
	                  <select id="svname" name="svname" style="width: 100%;">
                		{{ show_user_servers() }}
            		</select>
            		<button type="submit" class="btn btn-primary">Apply Server</button>
	                </div>
	              </div>
	              <div class="box-footer">
	                
	              </div>
	            </form>
	            
	            <div class="box-footer">
	            
          		</div>
          		
          	</div>
      	</div>
    </div>
</section>
@endsection
<ul class="nav navbar-nav navbar-right">
		<li class="">
		  <a href="javascript:;" class=" dropdown-toggle authpic" data-toggle="dropdown" aria-expanded="false">

              {{ auth('reception')->user()->name }}

			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">

              <li><a href="#" onclick="event.preventDefault();document.getElementById('logout-profile').submit();"><i class="fa fa-sign-out pull-right"></i> {{ trans('app.Log Out')}}</a>
                  <form id="logout-profile" action="{{ route('reception.auth.logout') }}" method="get" style="display: none;">
                      @csrf
                  </form>
              </li>

		  </ul>
		</li>

</ul>

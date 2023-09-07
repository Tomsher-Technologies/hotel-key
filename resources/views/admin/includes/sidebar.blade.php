<div class="deznav">
    <div class="deznav-scroll mm-active">
        <ul class="metismenu mm-show" id="menu">
            @if(Auth::user()->user_type != 'staff')
                <li class="{{ areActiveRoutes(['admin.dashboard']) }}">
                    <a class="" href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.29077 9L12.2908 2L21.2908 9V20C21.2908 20.5304 21.0801 21.0391 20.705 21.4142C20.3299 21.7893 19.8212 22 19.2908 22H5.29077C4.76034 22 4.25163 21.7893 3.87656 21.4142C3.50149 21.0391 3.29077 20.5304 3.29077 20V9Z" stroke="#252525" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path d="M9.29077 22V12H15.2908V22" stroke="#252525" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'hotel' || Auth::user()->user_type == 'staff')
                <li class="{{ areActiveRoutes(['all-bookings','add-booking','edit-booking']) }}">
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.007 16.2236H8.78699" stroke="#252525" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M16.007 12.0371H8.78699" stroke="#252525" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M11.5421 7.86035H8.78711" stroke="#252525" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.1994 2.75C16.1994 2.75 8.52238 2.754 8.51038 2.754C5.75038 2.771 4.04138 4.587 4.04138 7.357V16.553C4.04138 19.337 5.76338 21.16 8.54738 21.16C8.54738 21.16 16.2234 21.157 16.2364 21.157C18.9964 21.14 20.7064 19.323 20.7064 16.553V7.357C20.7064 4.573 18.9834 2.75 16.1994 2.75Z"
                                    stroke="#252525" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                        </div>
                        <span class="nav-text">Door Access</span>
                    </a>
                    <ul aria-expanded="false" class="mm-collapse" style="">
                        <li class="mini-dashboard">All</li>
                        <li><a href="{{ route('all-bookings') }}">History</a></li>
                        <li><a href="{{ route('add-booking') }}">Add New Access</a></li>
                    </ul>
                </li>
                @if(Auth::user()->user_type == 'hotel' )

                    <li class="{{ areActiveRoutes(['facilities']) }}">
                        <a href="{{ route('facilities') }}" class="" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.395 4.17701L15.2224 7.82776C15.4015 8.18616 15.7472 8.43467 16.1481 8.49218L20.2361 9.08062C21.2461 9.22644 21.6481 10.4505 20.9171 11.1519L17.961 13.9924C17.6704 14.2718 17.5382 14.6733 17.6069 15.0676L18.3046 19.0778C18.4764 20.0698 17.4205 20.8267 16.5178 20.3574L12.864 18.4627C12.5058 18.2768 12.0768 18.2768 11.7176 18.4627L8.06378 20.3574C7.161 20.8267 6.10517 20.0698 6.27801 19.0778L6.97462 15.0676C7.04334 14.6733 6.9111 14.2718 6.62059 13.9924L3.66445 11.1519C2.93349 10.4505 3.33541 9.22644 4.34544 9.08062L8.43342 8.49218C8.83431 8.43467 9.18105 8.18616 9.36014 7.82776L11.1865 4.17701C11.6384 3.27433 12.9431 3.27433 13.395 4.17701Z" stroke="#252525" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>	
                            <span class="nav-text">Facilities</span>
                        </a>
                    </li>
                    <li class="{{ areActiveRoutes(['all-staffs','add-staff','edit-staff']) }}">
                        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <div class="menu-icon">
                                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" fill="white"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87" fill="white"></path><path d="M16 3.13a4 4 0 0 1 0 7.75" fill="white"></path></svg>
                            </div>
                            <span class="nav-text">Staffs</span>
                        </a>
                        <ul aria-expanded="false" class="mm-collapse" style="">
                            <li class="mini-dashboard">All</li>
                            <li><a href="{{ route('all-staffs') }}">All Staffs</a></li>
                            <li><a href="{{ route('add-staff') }}">Add New Staff</a></li>
                        </ul>
                    </li>

                    <li class="{{ areActiveRoutes(['profile','update-profile']) }}">
                        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.007 16.2236H8.78699" stroke="#252525" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M16.007 12.0371H8.78699" stroke="#252525" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M11.5421 7.86035H8.78711" stroke="#252525" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.1994 2.75C16.1994 2.75 8.52238 2.754 8.51038 2.754C5.75038 2.771 4.04138 4.587 4.04138 7.357V16.553C4.04138 19.337 5.76338 21.16 8.54738 21.16C8.54738 21.16 16.2234 21.157 16.2364 21.157C18.9964 21.14 20.7064 19.323 20.7064 16.553V7.357C20.7064 4.573 18.9834 2.75 16.1994 2.75Z"
                                        stroke="#252525" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </div>
                            <span class="nav-text">My Profile</span>
                        </a>
                        <ul aria-expanded="false" class="mm-collapse" style="">
                            <li class="mini-dashboard">Profile</li>
                            <li><a href="{{ route('profile') }}">View Profile</a></li>
                            <li><a href="{{ route('update-profile') }}">Edit Profile</a></li>
                            <!-- <li><a href="{{ route('change-password') }}">Change Password</a></li> -->
                        </ul>
                    </li>
                @endif
                <li class="{{ areActiveRoutes(['tutorials']) }} ">
                    <a href="{{ route('tutorials') }}" class="" aria-expanded="false">
                        <div class="menu-icon ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.9026 8.85156L13.4593 12.4646C12.6198 13.1306 11.4387 13.1306 10.5992 12.4646L6.11841 8.85156" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9089 21C19.9502 21.0084 22 18.5095 22 15.4384V8.57001C22 5.49883 19.9502 3 16.9089 3H7.09114C4.04979 3 2 5.49883 2 8.57001V15.4384C2 18.5095 4.04979 21.0084 7.09114 21H16.9089Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                          
                        </div>	
                        <span class="nav-text">Tutorials</span>
                        
                    </a>
                </li>
            @endif

            @if(Auth::user()->user_type == 'hotel' || Auth::user()->user_type == 'admin')
                <li class="{{ areActiveRoutes(['support']) }} support-icon">
                    <a href="{{ route('support') }}" class="" aria-expanded="false">
                        <div class="menu-icon support-icon">
                            <div class=" ">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.9026 8.85156L13.4593 12.4646C12.6198 13.1306 11.4387 13.1306 10.5992 12.4646L6.11841 8.85156" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9089 21C19.9502 21.0084 22 18.5095 22 15.4384V8.57001C22 5.49883 19.9502 3 16.9089 3H7.09114C4.04979 3 2 5.49883 2 8.57001V15.4384C2 18.5095 4.04979 21.0084 7.09114 21H16.9089Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            
                            </div>	
                            @php
                                $supportCount = supportsCount();
                            @endphp
                            @if($supportCount != 0)
                                <span class="support-badge" > {{ $supportCount }} </span>
                            @endif
                        </div>	
                        <span class="nav-text">Support</span>
                        
                    </a>
                </li>
            @endif

            @if(Auth::user()->user_type == 'admin')

                <li class="{{ areActiveRoutes(['bookings']) }}">
                    <a class="" href="{{ route('bookings') }}" aria-expanded="false">
                        <div class="menu-icon">
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.007 16.2236H8.78699" stroke="#252525" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M16.007 12.0371H8.78699" stroke="#252525" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path d="M11.5421 7.86035H8.78711" stroke="#252525" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.1994 2.75C16.1994 2.75 8.52238 2.754 8.51038 2.754C5.75038 2.771 4.04138 4.587 4.04138 7.357V16.553C4.04138 19.337 5.76338 21.16 8.54738 21.16C8.54738 21.16 16.2234 21.157 16.2364 21.157C18.9964 21.14 20.7064 19.323 20.7064 16.553V7.357C20.7064 4.573 18.9834 2.75 16.1994 2.75Z"
                                    stroke="#252525" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                            </svg>
                        </div>
                        <span class="nav-text">All Access</span>
                    </a>
                </li>

                <li class="{{ areActiveRoutes(['all-hotels','add-hotel','edit-hotel']) }}">
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <div class="menu-icon">
                            <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox=" -2 0 22 20"fill="currentColor" class="bi bi-building"> <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z" fill="white"></path> <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z" fill="white"></path> </svg>
                        </div>
                        <span class="nav-text">Hotels</span>
                    </a>
                    <ul aria-expanded="false" class="mm-collapse" style="">
                        <li class="mini-dashboard">All</li>
                        <li><a href="{{ route('all-hotels') }}">All Hotels</a></li>
                        <li><a href="{{ route('add-hotel') }}">Add New Hotel</a></li>
                    </ul>
                </li>

                <li class="{{ areActiveRoutes(['all-users','add-user','edit-user']) }}">
                    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                        <div class="menu-icon">
                            <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" fill="white"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87" fill="white"></path><path d="M16 3.13a4 4 0 0 1 0 7.75" fill="white"></path></svg>
                        </div>
                        <span class="nav-text">Users</span>
                    </a>
                    <ul aria-expanded="false" class="mm-collapse" style="">
                        <li class="mini-dashboard">All</li>
                        <li><a href="{{ route('all-users') }}">All Users</a></li>
                        <li><a href="{{ route('add-user') }}">Add New User</a></li>
                    </ul>
                </li>

                <li class="{{ areActiveRoutes(['all-tutorials']) }} ">
                    <a href="{{ route('all-tutorials') }}" class="" aria-expanded="false">
                        <div class="menu-icon ">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.9026 8.85156L13.4593 12.4646C12.6198 13.1306 11.4387 13.1306 10.5992 12.4646L6.11841 8.85156" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9089 21C19.9502 21.0084 22 18.5095 22 15.4384V8.57001C22 5.49883 19.9502 3 16.9089 3H7.09114C4.04979 3 2 5.49883 2 8.57001V15.4384C2 18.5095 4.04979 21.0084 7.09114 21H16.9089Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                          
                        </div>	
                        <span class="nav-text">Tutorials</span>
                        
                    </a>
                </li>
            @endif

            <!-- <li class="menu-title">OTHERS</li> -->
            
            
        </ul>
        <div class="switch-btn">
            <a href="{{ route('logout') }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M18.36 6.63965C19.6184 7.89844 20.4753 9.50209 20.8223 11.2478C21.1693 12.9936 20.9909 14.803 20.3096 16.4474C19.6284 18.0918 18.4748 19.4972 16.9948 20.486C15.5148 21.4748 13.7749 22.0026 11.995 22.0026C10.2151 22.0026 8.47515 21.4748 6.99517 20.486C5.51519 19.4972 4.36164 18.0918 3.68036 16.4474C2.99909 14.803 2.82069 12.9936 3.16772 11.2478C3.51475 9.50209 4.37162 7.89844 5.63 6.63965"
                        stroke="#252525" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12 2V12" stroke="#252525" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>
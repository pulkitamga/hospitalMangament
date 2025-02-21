        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
              <a href="{{ route('dashboard') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="{{ asset('assets/img/MidCoast_Central_Logo_Color.png') }}" alt="Logo" width="200">
                </span>
              </a>
  
              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
              </a>
            </div>
  
            <div class="menu-inner-shadow"></div>
  
            <ul class="menu-inner py-1">
              <!-- Dashboards -->
              <li class="menu-item active open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-home-smile"></i>
                  <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
                </a>
                
              </li>
  
              <!-- Apps & Pages -->
              <li class="menu-header small text-uppercase">
                <span class="menu-header-text">User &amp; Management</span>
              </li>
              <!-- Pages -->
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-dock-top"></i>
                  <div class="text-truncate" data-i18n="Account Settings">User Management</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="{{route('users.index')}}" class="menu-link">
                      <div class="text-truncate" data-i18n="Account">User</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{ route('work-leaves.index') }}" class="menu-link">
                      <div class="text-truncate" data-i18n="Notifications">Work Leaves</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Connections">Role</div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                  <div class="text-truncate" data-i18n="Authentications">Patients & Medical Records</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="{{ route('patients.index') }}" class="menu-link" target="_blank">
                      <div class="text-truncate" data-i18n="Basic">Patients</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="auth-register-basic.html" class="menu-link" target="_blank">
                      <div class="text-truncate" data-i18n="Basic">Visits</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                      <div class="text-truncate" data-i18n="Basic">Appointments </div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="auth-register-basic.html" class="menu-link" target="_blank">
                      <div class="text-truncate" data-i18n="Basic">Birth Reports </div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                      <div class="text-truncate" data-i18n="Basic">Lab Orders  </div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                      <div class="text-truncate" data-i18n="Basic">Lab Results  </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                  <div class="text-truncate" data-i18n="Misc">Hospital Departments & Staff</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="{{ route('departments.index') }}" class="menu-link">
                      <div class="text-truncate" data-i18n="Error">Department</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="pages-misc-under-maintenance.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Under Maintenance">Employees</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{ route('doctors.index') }}" class="menu-link">
                      <div class="text-truncate" data-i18n="Under Maintenance">Docters</div>
                    </a>
                  </li>
                </ul>
              </li>
              
              <!-- Hospital Facilities -->
              <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-box"></i>
                  <div class="text-truncate" data-i18n="User interface">Hospital Facilities (Rooms & Beds)</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="ui-accordion.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Accordion">Rooms </div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="ui-alerts.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Alerts">Beds</div>
                    </a>
                  </li>
                </ul>
              </li>
  
              <!-- Billing & Payments -->
              <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-copy"></i>
                  <div class="text-truncate" data-i18n="Extended UI">Billing & Payments </div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Perfect Scrollbar">Bills</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="extended-ui-text-divider.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Text Divider"> Payments</div>
                    </a>
                  </li>
                </ul>
              </li>

  
              <!-- Medicines & Pharmacy -->
              <li class="menu-header small text-uppercase"><span class="menu-header-text">Medicines &amp; Pharmacy</span></li>
              <!-- Forms -->
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-detail"></i>
                  <div class="text-truncate" data-i18n="Form Elements">Medicines & Pharmacy</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="forms-basic-inputs.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Basic Inputs">Medicines </div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="forms-input-groups.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Input groups">Medicine Names</div>
                    </a>
                  </li>
                </ul>
              </li>


              <!-- Laboratory & Tests -->
              <li class="menu-header small text-uppercase"><span class="menu-header-text">Laboratory &amp; Tests</span></li>
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-detail"></i>
                  <div class="text-truncate" data-i18n="Form Elements">Laboratory & Tests</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="forms-basic-inputs.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Basic Inputs">Lab Tests</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="forms-input-groups.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Input groups">Lab Orders</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="forms-input-groups.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Input groups">Lab Results</div>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Inventory & Items Management -->
              <li class="menu-header small text-uppercase"><span class="menu-header-text">Inventory &amp; Items Management</span></li>
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-detail"></i>
                  <div class="text-truncate" data-i18n="Form Elements">Inventory & Items Management</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="forms-basic-inputs.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Basic Inputs">Items</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="forms-input-groups.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Input groups">Item Assigns</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="forms-input-groups.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Input groups">Item Requests</div>
                    </a>
                  </li>
                </ul>
              </li>

              <!-- Education & Work Experience -->
              <li class="menu-header small text-uppercase"><span class="menu-header-text">Education &amp; Work Experience</span></li>
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-detail"></i>
                  <div class="text-truncate" data-i18n="Form Elements">Education & Work Experience</div>
                </a>
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="forms-basic-inputs.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Basic Inputs">Education Information</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="forms-input-groups.html" class="menu-link">
                      <div class="text-truncate" data-i18n="Input groups">Work Experience</div>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </aside>
          <!-- / Menu -->
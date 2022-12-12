<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
        <ul id="sidebarnav" class="pt-4">
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.dashboard')}}"
              aria-expanded="false"
              ><i class="mdi mdi-view-dashboard"></i
              ><span class="hide-menu">Dashboard</span></a
            >
          </li>
          @permission('add-admin-user')
        <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.listUser')}}"
              aria-expanded="false"
              ><i class="mdi mdi-account"></i
              ><span class="hide-menu">Admin Users</span></a
            >
          </li>
          @endpermission
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.wallet-admin')}}"
              aria-expanded="false"
              ><i class="mdi mdi-account"></i
              ><span class="hide-menu">Admin Wallet</span></a
            >
          </li>
          @permission('roles')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.role.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-move-resize-variant"></i
              ><span class="hide-menu">Roles</span></a
            >
          </li>
          @endpermission
          @permission('user-roles')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark"
              href="{{route('admin.user.role.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-move-resize-variant"></i
              ><span class="hide-menu">User Roles</span></a
            >
          </li>
          @endpermission
          @permission('permissions')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.permission.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-move-resize-variant"></i
              ><span class="hide-menu">Permissions</span></a
            >
          </li>
          @endpermission
          @permission('role-permissions')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.rolepermission.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-move-resize-variant"></i
              ><span class="hide-menu">Role Permissions</span></a
            >
          </li>
          @endpermission
          @permission('mentor-category')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.mentor.category.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">Consultant Category</span></a
            >
          </li>
          @endpermission
          @permission('mentor')
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-receipt"></i
              ><span class="hide-menu">Consultant </span></a
            >
            <ul aria-expanded="false" class="collapse first-level">
                @permission('pending-mentor')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor.pending.list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Pending Consultant </span></a
                >
              </li>
              @endpermission
              @permission('approved-mentor')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor.approved.list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Approved Consultant </span></a
                >
              </li>
              @endpermission
              @permission('rejected-mentor')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor.rejected.list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Rejected Consultant </span></a
                >
              </li>
              @endpermission
              @permission('add-mentor')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor.add')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Add Consultant </span></a
                >
              </li>
              @endpermission
              @permission('add-mentor-education')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor.add.education')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Add Consultant Education </span></a
                >
              </li>
              @endpermission
              @permission('add-mentor-experience')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor.add.experience')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Add Consultant Experience </span></a
                >
              </li>
              @endpermission
            </ul>
          </li>
          @endpermission
          @permission('mentor-occupation')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.mentor.occupation.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">Consultant Occupation</span></a
            >
          </li>
          @endpermission
          @permission('mentor-degree')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.mentor.degree.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">Consultant Degree</span></a
            >
          </li>
          @endpermission
          @permission('mentor-bank-list')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.mentor.bank.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">Consultant Bank List</span></a
            >
          </li>
          @endpermission
          @permission('mentee-list')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.mentee.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i>
              <span class="hide-menu">User List</span>
            </a>
          </li>
          @endpermission
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{route('admin.newsletter.list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i>
              <span class="hide-menu">Newsletter List</span>
            </a>
          </li>
          @permission('appointment-logs')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{url('admin/appointment-log')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">Appointment Logs</span></a
            >
          </li>
          @endpermission
          @permission('contact-us-list')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{url('admin/contact-us-list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">Contact Us List</span></a
            >
          </li>
          @endpermission
          @permission('withdraw-request-list')
          <li class="sidebar-item">
            <a
              class="sidebar-link waves-effect waves-dark sidebar-link"
              href="{{url('admin/withdraw-list')}}"
              aria-expanded="false"
              ><i class="mdi mdi-chart-bar"></i
              ><span class="hide-menu">WithDraw Request List</span></a
            >
          </li>
          @endpermission
          @permission('blogs')
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-receipt"></i
              ><span class="hide-menu">Blogs </span></a
            >
            <ul aria-expanded="false" class="collapse first-level">
                @permission('add-blogs')
              <li class="sidebar-item">
                <a
                href="{{route('admin.blog.list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Blog Posts </span></a
                >
              </li>
              @endpermission
              @permission('add-blog-category')
              <li class="sidebar-item">
                <a
                href="{{route('admin.blog.category.list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Category </span></a
                >
              </li>
              @endpermission
            </ul>
          </li>
          @endpermission
          @permission('payment-configuration')
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-receipt"></i
              ><span class="hide-menu">Payment Configuration </span></a
            >
            <ul aria-expanded="false" class="collapse first-level">
                {{-- @permission('add-jazzcash') --}}
              <li class="sidebar-item">
                <a
                href="{{route('admin.payment_gateway.add')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Add Payment Method </span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                href="{{route('admin.payment_settings.add')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu"> Add Payment Method Settings</span></a
                >
              </li>
              {{-- @endpermission --}}
              @permission('add-easypaisa')
              <li class="sidebar-item">
                <a
                href="{{route('admin.easypaisa_payment_gateway.add')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> EasyPaisa </span></a
                >
              </li>
              @endpermission
              @permission('add-jazzcash')
              <li class="sidebar-item">
                <a
                href="{{route('admin.jazz_gateway.add')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> JazzCash </span></a
                >
              </li>
              @endpermission
            </ul>
          </li>
          @endpermission
          @permission('appointment-ledger')
          <li class="sidebar-item">
            <a
              class="sidebar-link has-arrow waves-effect waves-dark"
              href="javascript:void(0)"
              aria-expanded="false"
              ><i class="mdi mdi-receipt"></i
              ><span class="hide-menu">Appointment Ledger </span></a
            >
            <ul aria-expanded="false" class="collapse first-level">
                @permission('mentee-appointment-ledger')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentee-list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-outline"></i
                  ><span class="hide-menu">User Appointment Ledger </span></a
                >
              </li>
              @endpermission
              @permission('mentor-appoitment-ledger')
              <li class="sidebar-item">
                <a
                href="{{route('admin.mentor-list')}}"
                class="sidebar-link"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu"> Consultant Appointment Ledger</span></a
                >
              </li>
              @endpermission



            </ul>

            <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="{{route('admin.commission.add')}}"
                  aria-expanded="false"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu">Commission Setup</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="{{route('admin.general.add')}}"
                  aria-expanded="false"
                  ><i class="mdi mdi-note-plus"></i
                  ><span class="hide-menu">General Settings</span></a
                >
              </li>
          </li>
          @endpermission
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>

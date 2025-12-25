<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class='sidebar-brand' href='{{ route('dashboard') }}'>
            <span class="sidebar-brand-text align-middle">
                {{ config('app.name') }}
            </span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>
            <li class="sidebar-item active">
                <a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboards</span>
                </a>
                <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar">
                    <li class="sidebar-item active"><a class='sidebar-link'
                            href="{{ route('dashboard') }}">Analytics</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='dashboard-ecommerce.html'>E-Commerce
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='dashboard-crypto.html'>Crypto
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="layout"></i> <span class="align-middle">Pages</span>
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-settings.html'>Settings</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-projects.html'>Projects
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-clients.html'>Clients
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-orders.html'>Orders
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-pricing.html'>Pricing
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-chat.html'>Chat <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-blank.html'>Blank
                            Page</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='pages-profile.html'>
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='pages-invoice.html'>
                    <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Invoice</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='pages-tasks.html'>
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tasks</span>
                    <span class="sidebar-badge badge bg-primary">Pro</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class='sidebar-link' href='calendar.html'>
                    <i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Calendar</span>
                    <span class="sidebar-badge badge bg-primary">Pro</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#auth" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Auth</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-sign-in.html'>Sign
                            In</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-sign-up.html'>Sign
                            Up</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-reset-password.html'>Reset
                            Password <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-404.html'>404 Page <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='pages-500.html'>500 Page <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                </ul>
            </li>

            <li class="sidebar-header">
                Components
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">UI
                        Elements</span>
                </a>
                <ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-alerts.html'>Alerts <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-buttons.html'>Buttons</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-cards.html'>Cards</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-general.html'>General</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-grid.html'>Grid</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-modals.html'>Modals <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-offcanvas.html'>Offcanvas
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-placeholders.html'>Placeholders
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-tabs.html'>Tabs <span
                                class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='ui-typography.html'>Typography</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#icons" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
                    <span class="sidebar-badge badge bg-light">1.500+</span>
                </a>
                <ul id="icons" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='icons-feather.html'>Feather</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link' href='icons-font-awesome.html'>Font
                            Awesome <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">Forms</span>
                </a>
                <ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' href='forms-basic-inputs.html'>Basic
                            Inputs</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='forms-layouts.html'>Form
                            Layouts
                            <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                    <li class="sidebar-item"><a class='sidebar-link' href='forms-input-groups.html'>Input
                            Groups <span class="sidebar-badge badge bg-primary">Pro</span></a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a class='sidebar-link' href='tables-bootstrap.html'>
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tables</span>
                </a>
            </li>

            <li class="sidebar-header">
                Lookups
            </li>
            <li class="sidebar-item active">
                <a data-bs-target="#lookups" data-bs-toggle="collapse" class="sidebar-link">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Lookups</span>
                </a>
                <ul id="lookups" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar">
                    <li class="sidebar-item active"><a class='sidebar-link'
                            href="{{ route('categories.index') }}">Categories</a>
                    </li>
                    <li class="sidebar-item"><a class='sidebar-link'
                            href="{{ route('branches.index') }}">Branches</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-header">
                Settings
            </li>

            <li class="sidebar-item active">
                <a class='sidebar-link' href="{{ route('setting') }}">
                    <i class="align-middle" data-feather="settings"></i>
                    <span class="align-middle">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</nav>

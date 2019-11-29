<div class="adminx-sidebar expand-hover push">
    <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
            <a href="{{ url('/') }}" class="sidebar-nav-link active">
                    <span class="sidebar-nav-icon">
                        <i data-feather="home"></i>
                    </span>
                <span class="sidebar-nav-name">
                        Dashboard
                      </span>
                <span class="sidebar-nav-end">
                    </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('extraction.index') }}" class="sidebar-nav-link">
              <span class="sidebar-nav-icon">
                <i data-feather="layout"></i>
              </span>
                <span class="sidebar-nav-name">
                Extraction
              </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('annotation.index') }}" class="sidebar-nav-link">
              <span class="sidebar-nav-icon">
                <i data-feather="layout"></i>
              </span>
                <span class="sidebar-nav-name">
                Annotation
              </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="{{ route('train.index') }}" class="sidebar-nav-link">
              <span class="sidebar-nav-icon">
                <i data-feather="layout"></i>
              </span>
                <span class="sidebar-nav-name">
                Train
              </span>
            </a>
        </li>
    </ul>
</div>

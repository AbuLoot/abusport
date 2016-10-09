
        <ul class="nav nav-pills nav-justified">
          <li @if (Request::is('admin/pages', 'admin/pages/*')) class="active" @endif><a href="/admin/pages">Страницы</a></li>
          <li @if (Request::is('admin/users', 'admin/users/*')) class="active" @endif><a href="/admin/users">Пользователи</a></li>
          <li @if (Request::is('admin/organizations', 'admin/organizations/*')) class="active" @endif><a href="/admin/organizations">Организации</a></li>
          <li @if (Request::is('admin/countries', 'admin/countries/*')) class="active" @endif><a href="/admin/countries">Страны</a></li>
          <li @if (Request::is('admin/cities', 'admin/cities/*')) class="active" @endif><a href="/admin/cities">Города</a></li>
          <li @if (Request::is('admin/districts', 'admin/districts/*')) class="active" @endif><a href="/admin/districts">Районы</a></li>
          <li @if (Request::is('admin/sports', 'admin/sports/*')) class="active" @endif><a href="/admin/sports">Спорт</a></li>
          <li @if (Request::is('admin/areas', 'admin/areas/*')) class="active" @endif><a href="/admin/areas">Площадки</a></li>
          <li @if (Request::is('admin/matches', 'admin/matches/*')) class="active" @endif><a href="/admin/matches">Матчи</a></li>
          <li @if (Request::is('admin/settings', 'admin/settings/*')) class="active" @endif><a href="#/admin/settings">Настройки</a></li>
        </ul>
<div id="sidebar" class="sidebar responsive ace-save-state compact sidebar-fixed">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<div class="nav-wrap-up pos-rel">
		<div class="nav-wrap" style>
			<div style="position: relative; top: 0px; transition-property: top; transition-duration: 0.15s;">
				<ul class="nav nav-list">
					<li class="<?php if($menu=='') echo "active"; ?>">
						<a href="./">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Beranda </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='pengguna') echo "active"; ?>">
						<a href="./index.php?menu=pengguna">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text"> Pengguna </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='peramalan') echo "active"; ?>">
						<a href="./index.php?menu=peramalan">
							<i class="menu-icon fa fa-bar-chart"></i>
							<span class="menu-text"> Peramalan </span>
						</a>

						<b class="arrow"></b>
					</li>


					<li class="<?php if($menu=='laporan') echo "active"; ?>">
						<a href="./index.php?menu=laporan">
							<i class="menu-icon fa fa-file-text-o"></i>
							<span class="menu-text"> Laporan </span>
						</a>

						<b class="arrow"></b>
					</li>
				</ul><!-- /.nav-list -->
			</div>
		</div>
	</div>

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>

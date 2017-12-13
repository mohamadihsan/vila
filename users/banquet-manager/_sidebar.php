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

					<li class="<?php if($menu=='bahan-makanan') echo "active"; ?>">
						<a href="./index.php?menu=bahan-makanan">
							<i class="menu-icon fa fa-cubes"></i>
							<span class="menu-text"> Bahan Makanan </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='menu') echo "active"; ?>">
						<a href="./index.php?menu=menu">
							<i class="menu-icon fa fa-file-text-o"></i>
							<span class="menu-text"> Menu </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='resep') echo "active"; ?>">
						<a href="./index.php?menu=resep">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Resep </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='permintaan-menu') echo "active"; ?>">
						<a href="./index.php?menu=permintaan-menu">
							<i class="menu-icon fa fa-reorder"></i>
							<span class="menu-text"> Pemesanan Menu </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='kebutuhan-bahan') echo "active"; ?>">
						<a href="./index.php?menu=kebutuhan-bahan">
							<i class="menu-icon fa fa-exclamation"></i>
							<span class="menu-text"> Kebutuhan Bahan </span>
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
				</ul><!-- /.nav-list -->
			</div>
		</div>
	</div>			

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>
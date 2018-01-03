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

					<li class="<?php if($menu=='kategori') echo "active"; ?>">
						<a href="./index.php?menu=kategori">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Kategori Bahan Makanan </span>
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

					<li class="<?php if($menu=='pemesanan-bahan') echo "active"; ?>">
						<a href="./index.php?menu=pemesanan-bahan">
							<i class="menu-icon fa fa-reorder"></i>
							<span class="menu-text"> Pemesanan Bahan </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='permintaan-kebutuhan-bahan-makanan') echo "active"; ?>">
						<a href="./index.php?menu=permintaan-kebutuhan-bahan-makanan">
							<i class="menu-icon fa fa-file-text"></i>
							<span class="menu-text"> Permintaan Bahan </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='barang-keluar') echo "active"; ?>">
						<a href="./index.php?menu=barang-keluar">
							<i class="menu-icon fa fa-retweet text-danger"></i>
							<span class="menu-text"> Barang Keluar </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='persediaan') echo "active"; ?>">
						<a href="./index.php?menu=persediaan">
							<i class="menu-icon fa fa-file-text-o"></i>
							<span class="menu-text"> Persediaan </span>
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

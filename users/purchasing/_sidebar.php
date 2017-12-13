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
			
					<li class="<?php if($menu=='supplier') echo "active"; ?>">
						<a href="./index.php?menu=supplier">
							<i class="menu-icon fa fa-building"></i>
							<span class="menu-text"> Supplier </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="<?php if($menu=='pemesanan') echo "active"; ?>">
						<a href="./index.php?menu=pemesanan">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text"> Pemesanan Bahan</span>
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
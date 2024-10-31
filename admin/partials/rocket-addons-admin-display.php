<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rocket-addons.com/
 * @since      1.0.0
 *
 * @package    Rocket_Addon
 * @subpackage Rocket_Addon/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="rocket-admin-dashboard">
	<form action="">
		<div class="rocket-head-banner">
			<div class="head-banner-inner">
				<div class="head-banner-img">
					<img src="<?php echo esc_url( ROCKET_ADDON_URL . 'assets/rocket-head-banner.svg' ); ?>" alt="rocket-banner">
				</div>
			</div>
		</div>
		<div class="rocket-dashboard-contents">
			<nav class="rocket-tab">
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" href="admin.php?page=rocket-addons-for-elementor">
						<i class="batavia icon-gears-setting"></i>
						<?php esc_html_e( 'General', 'rocket-addons' ); ?>
					</a>
					<a class="nav-item nav-link" href="admin.php?page=rocket-addons-for-elementor-addons">
						<i class="batavia icon-box"></i>
						<?php esc_html_e( 'Add-Ons', 'rocket-addons' ); ?>
					</a>
					<?php if ( rocket_addons_fs()->is__premium_only() ) { ?>
					<a class="nav-item nav-link" href="admin.php?page=rocket-addons-for-elementor-account">
						<i class="batavia icon-wrench1"></i>
						<?php esc_html_e( 'Account', 'rocket-addons' ); ?>
					</a>
					<?php } ?>
					<a class="nav-item nav-link" href="admin.php?page=rocket-addons-for-elementor-contact">
						<i class="batavia icon-plug"></i>
						<?php esc_html_e( 'Contact Us', 'rocket-addons' ); ?>
					</a>
					<?php if ( rocket_addons_fs()->is_not_paying() ) { ?>
					<a class="nav-item nav-link" href="<?php echo esc_url( rocket_addons_fs()->get_upgrade_url() ); ?>">
						<i class="batavia icon-unlock"></i>
						<?php esc_html_e( 'Go Premium', 'rocket-addons' ); ?>
					</a>
					<?php } ?>
				</div>
			</nav>
			<div class="rocket-tab-content tab-content" id="nav-tabContent">
				<div class="rocket-home-content">
					<div class="left-section-outer">
						<div class="rdash-banner">
							<img src="<?php echo esc_url( ROCKET_ADDON_URL . 'assets/rocket-banner.svg' ); ?>" alt="rbanner">
						</div>
						<div class="left-section rhome-section">
							<div class="left-item rhome-wids docs-box">
								<div class="rhome-wid-in">
									<div class="rhome-wid-ico">
										<i class="batavia icon-book"></i>
									</div>
									<div class="wid-in-con">
										<h4 class="wid-title"><?php esc_html_e( 'Documentation', 'rocket-addons' ); ?></h4>
										<p class="wid-cont">
											<?php esc_html_e( 'Get started by spending some time with the documentation to get familiar with Rocket Addons.', 'rocket-addons' ); ?>
										</p>
										<a href="https://rocket-addons.com/documentation/" class="wid-btn"><?php esc_html_e( 'Knowledge Base', 'rocket-addons' ); ?></a>
									</div>
								</div>
							</div>
							<div class="right-item rhome-wids report-box">
								<div class="rhome-wid-in">
									<div class="rhome-wid-ico">
										<i class="batavia icon-bug"></i>
									</div>
									<div class="wid-in-con">
										<h4 class="wid-title"><?php esc_html_e( 'Contribute to Rocket Addons', 'rocket-addons' ); ?></h4>
										<p class="wid-cont">
											<?php esc_html_e( 'You can contribute to make Rocket Addons better with reporting bugs, creating issue and help us make an improve.', 'rocket-addons' ); ?>
										</p>
										<a href="https://rocket-addons.com/contact-us/" class="wid-btn"><?php esc_html_e( 'Report a bug', 'rocket-addons' ); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="right-section rhome-section">
						<div class="rocket-upgrade-area">
							<img src="<?php echo esc_url( ROCKET_ADDON_URL . 'assets/rocket-upgrade.svg' ); ?>" alt="rocket-banner">
							<?php if ( rocket_addons_fs()->is_not_paying() ) { ?>
							<div class="rbutton-upgrade">
								<a href="<?php echo esc_url( rocket_addons_fs()->get_upgrade_url() ); ?>" class="rbutton"><?php esc_html_e( 'Upgrade to Pro', 'rocket-addons' ); ?></a>
							</div>
							<?php } else { ?>
								<div class="rbutton-upgrade">
									<a href="<?php echo esc_url( rocket_addons_fs()->get_account_url() ); ?>" class="rbutton"><?php esc_html_e( 'See Your Plan', 'rocket-addons' ); ?></a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

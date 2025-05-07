<!DOCTYPE html>

<html lang="en" dir="ltr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Sign On</title>
    <base href=".">

    <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?=$this->getUrl('vandy-login-page/main-generic-v.css')?>">
</head>
<body>
<div class="ping-container ping-signin">
    <div class="ping-header">
        Sign On
    </div>
    <!-- .ping-header -->
    <div class="ping-body-container">
        <div class="section-title">
            Please sign in to pre-fill survey information.
        </div>
        <div>
            <form method="POST" autocomplete="off" _lpchecked="1">
                <div class="ping-messages">
					<div class="ping-error"><?=$errorMessage?></div>
                </div>

                <div class="ping-input-label">
                    VUNet ID
                </div>
                <div class="ping-input-container">
					<input id="username" type="text" size="36" name="vunetid" value="<?=$vunetid?>" autocorrect="off" autocapitalize="off" placeholder="Username" autocomplete="off" style="min-height: 34px; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAXFJREFUOBGVVDGKwkAUfZHFaBBS2riQSrC18QJpAvbeYAVbD6DxFm4TELyA1R7BKmUgjRa7pAwELKKF2XljEuMSN/HDZOb//96b+X+GKLZtW0mSrMV4Rw1TFOVbwD6Wy+UX4Y1XyCSkG31yTaNArZ1v8Nu3yGkUE1VrTdPQ7/cfYC8JGIYB0zTLBVqtVp5QVRWiWblfzOXBdPHGeTweYzgcYrvdIgxDzGYzBEEAx3Eecn/J9F8qoUxAWSwWCRM8ZhzHEsMSzudzGT6PiRJ/hDPNT5CRiagiEyOusiemtewBA//ZZDLBYDDIIavVCtfrVYrUEmi324iiCPv9XoqQnFkjfduZXzpToNlsykdUJBNMgWmViO/78DwPuq7DsizwQWV2fy1ZJJ2z26Hb6XRwOp0wGo2kwG63g+u6ElmrB/P5XApQ6HK54HA4pNsATwV4z+lVYbPZoNvtys6zHDaURsxTAZFnb/ij6R2PR3AUjWRifgHmko6KAvVfRAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;"><!---->
				</div>

                <div class="ping-input-label">
                    Password
                </div>
                <div class="ping-input-container">
                    <input id="password" type="password" size="36" name="password" placeholder="Password" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAXFJREFUOBGVVDGKwkAUfZHFaBBS2riQSrC18QJpAvbeYAVbD6DxFm4TELyA1R7BKmUgjRa7pAwELKKF2XljEuMSN/HDZOb//96b+X+GKLZtW0mSrMV4Rw1TFOVbwD6Wy+UX4Y1XyCSkG31yTaNArZ1v8Nu3yGkUE1VrTdPQ7/cfYC8JGIYB0zTLBVqtVp5QVRWiWblfzOXBdPHGeTweYzgcYrvdIgxDzGYzBEEAx3Eecn/J9F8qoUxAWSwWCRM8ZhzHEsMSzudzGT6PiRJ/hDPNT5CRiagiEyOusiemtewBA//ZZDLBYDDIIavVCtfrVYrUEmi324iiCPv9XoqQnFkjfduZXzpToNlsykdUJBNMgWmViO/78DwPuq7DsizwQWV2fy1ZJJ2z26Hb6XRwOp0wGo2kwG63g+u6ElmrB/P5XApQ6HK54HA4pNsATwV4z+lVYbPZoNvtys6zHDaURsxTAZFnb/ij6R2PR3AUjWRifgHmko6KAvVfRAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                </div>

				<input name="<?=static::LDAP_SURVEY_PREFILL?>" value="true" type="hidden">

				<!-- This input exists solely to allow the survey instructions to display. -->
				<input name="__prefill" type="hidden">

                <div class="ping-buttons">
                    <input type="hidden" name="pf.ok" value="">
                    <input type="hidden" name="pf.cancel" value="">

                    <button class="ping-button normal allow" title="Sign On" onclick="window.onbeforeunload = null; form.submit(); // Override onbeforeunload, since REDCap's implementation triggers unnecessarily sometimes on the login page">
                        Sign On
                    </button>

                </div><!-- .ping-buttons -->

            </form>
        </div><!-- .ping-body -->
    </div><!-- .ping-body-container -->
    <div class="ping-footer-container">
        <div class="ping-footer">
            <div class="ping-credits">
        </div> <!-- .ping-footer -->
    </div> <!-- .ping-footer-container -->
</div><!-- .ping-container -->

</div></body></html>
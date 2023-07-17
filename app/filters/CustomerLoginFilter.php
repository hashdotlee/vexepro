<?php
class CustomerLoginFilter extends Filter {
    public function doFilter(string $url) : void {
        if (!array_key_exists('userObj', $_SESSION)) {
            $this->redirect('/vexepro/auth/login?redirectUrl='.$url);
        }
    }
}
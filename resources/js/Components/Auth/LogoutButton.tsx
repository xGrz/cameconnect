import {router, usePage} from "@inertiajs/react";
import {PowerSettingsNew} from "@mui/icons-material";
import {IconButton} from "@mui/material";

export default function LogoutButton() {
    const {isLoggedIn} = usePage().props;

    const handleLogout = () => {
        router.delete(route('logout'))
    }

    if (!isLoggedIn) return '';
    return (
        <>
            <IconButton onClick={handleLogout} color="inherit">
                <PowerSettingsNew/>
            </IconButton>
        </>
    )

}

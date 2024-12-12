import {IconButton} from "@mui/material";
import {Settings} from "@mui/icons-material";
import {router} from "@inertiajs/react";

export default function SettingsButton() {

    const handleSettingsClick = () => {
        router.get(route('settings.index'));
    }

    return (
        <IconButton color="inherit" onClick={() => handleSettingsClick()}>
            <Settings />
        </IconButton>
    )
}

import {AccountTree} from "@mui/icons-material";
import {IconButton} from "@mui/material";
import {router} from "@inertiajs/react";

export default function SitesTreeButton() {


    function handleClick() {
        router.get(route('sites'))
    }

    return (
        <IconButton  color="inherit" onClick={() => handleClick()}>
            <AccountTree/>
        </IconButton>
    )
}

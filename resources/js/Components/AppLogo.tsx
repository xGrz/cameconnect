import {Link} from "@inertiajs/react";
import Typography from "@mui/material/Typography";

export default function AppLogo() {
    return (
        <Typography variant="h6" noWrap component="div" textAlign="center" sx={{flexGrow: 1}}>
            <Link
                href={route('home')}
                style={{textDecoration: 'none', color: 'white'}}
            >
                <strong>myCAME</strong> Connect
            </Link>
        </Typography>
    )
}


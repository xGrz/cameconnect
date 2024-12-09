import {ListItemIcon, SxProps} from "@mui/material";

interface DeviceIconProps {
    iconFileName: string|null;
    sx?: SxProps;
}

export default function DeviceIcon({iconFileName, sx}: DeviceIconProps) {
    return (
        <ListItemIcon sx={sx}>
            <img src={'https://cameconnect.net/assets/images/sprites/' + iconFileName + '.png'} style={{width: '60px', height: '60px', border: '3px solid #009EE0', borderRadius: 50, padding: 1}} />
        </ListItemIcon>
    );
}

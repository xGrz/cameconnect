import {ListItem, unstable_ClassNameGenerator} from "@mui/material";
import Typography from "@mui/material/Typography";
import DeviceIcon from "@/Components/Devices/DeviceIcon";
import {IDevice} from "@/types/inertia";


interface DeviceListItemProps {
    level?: number;
    device: IDevice;
}

export default function DeviceListItem({device, level = 1}: DeviceListItemProps) {

    return (
        <>
            <ListItem sx={{paddingLeft: level * 3}}>
                <DeviceIcon iconFileName={device.IconName} sx={{marginRight: 1}}/>
                <Typography variant="h6" component="div">
                    {device.Name}
                </Typography>
            </ListItem>
            {device.Children && device.Children.map(device => (
                <DeviceListItem device={device} key={device.Id} level={level + 1}/>
            ))}
        </>
    )
}


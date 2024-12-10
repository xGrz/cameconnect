import {IGatewayDevice} from "@/types/inertia";
import {List, ListItem, ListItemText} from "@mui/material";
import DeviceListItem from "@/Components/Connect/DeviceListItem";
import DeviceIcon from "@/Components/Connect/DeviceIcon";

interface GatewayListItemProps {
    gateway: IGatewayDevice;
}

export default function GatewayListItem({gateway}: GatewayListItemProps) {
    return (
        <>
            <ListItem sx={{marginLeft: 3}}>
                <DeviceIcon iconName={gateway.iconName} online={gateway.status.online}/>
                <ListItemText secondary={gateway.modelId}>{gateway.name}</ListItemText>
            </ListItem>
            {gateway.devices.length > 0 && (
                <List>
                    {gateway.devices.map((device) => (
                        <DeviceListItem key={device.id} device={device}/>
                    ))}
                </List>
            )}
        </>
    )
}
export interface IBaseResponse extends Record<string, any> {
    isLoggedIn: boolean;
}

interface IDeviceStatus {
    online: boolean,
}

interface IBaseDevice {
    id: number;
    name: string;
    description: string;
    iconName: string;
    modelId: number;
    modelName: string;
    status: IDeviceStatus;
}

interface ICommand {
    commandId: number;
    label: string;
    outputId: number;
}

interface IDevice extends IBaseDevice{
    devices: IDevice[];
    commands: ICommand[];
}

interface IGatewayDevice extends IBaseDevice {
    devices: IDevice[];
    iconName: string;
    keyCode: string;
}

interface ISite extends IBaseDevice {
    timezone: string;
    technicianId: number;
    devices: IGatewayDevice[];
    deviceIds: number[];
}

export interface IHomeResponse extends IBaseResponse {
    siteList: ISite[];
}

